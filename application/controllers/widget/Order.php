<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function ordersummary($token)
	{	
        $cookie = stripslashes($_COOKIE['variant']);
        $all_variant = json_decode($cookie, true);

        // echo '<pre>'.print_r($all_variant,true).'</pre>';
        // die;
        // Killua BEARER TOKEN
        // bbe287cf3a3bf23306bb175c8461ce86a16f6a75

        // echo '<pre>'.print_r(getToken(),true).'</pre>';
        // die;
        // $token = 'bbe287cf3a3bf23306bb175c8461ce86a16f6a75';
        // bbe287cf3a3bf23306bb175c8461ce86a16f6a75""

        // $mdata = array(
        //     "alamat"    => "Jln Denpasar Singaraja, Mengwi",
        //     "phone"     => "085123123123",
        // );

        $urlAddress 		= URLAPI . "/v1/mobile/order/last_address";
		$responseAddress 	= mobileAPI($urlAddress, $mdata = NULL, $token);
        $resultAddress      = $responseAddress->result->messages;

        // echo '<pre>'.print_r($resultAddress,true).'</pre>';
        // die;
        // if(empty($resultAddress)){
        //     echo '<pre>'.print_r("MASUK SINI",true).'</pre>';
        //     die;
        // }

        $urlCabang 		= URLAPI . "/v1/mobile/outlet/getcabang_byid?id=".$_GET['cabang'];
		$responseCabang 	= expatAPI($urlCabang);
        $resultCabang      = $responseCabang->result->messages;
        // echo '<pre>'.print_r($resultCabang,true).'</pre>';
        // die;

            // if(isset($all_variant)){
                
            // }
        $variant = array();
        foreach($all_variant as $av){
            $detail_variant = expatAPI(URLAPI . "/v1/mobile/produk/get_detailbyid?id=".$av['id_variant'])->result->messages;
            $detail_produk  = expatAPI(URLAPI . "/v1/mobile/produk/getproduk_byid?id=".$detail_variant->id_produk)->result->messages;
            $data = array(
                "id"                => $detail_variant->id,
                "id_produk"         => $detail_variant->id_produk,
                "picture"           => $detail_produk->picture,
                "nama"              => $detail_produk->nama,
                "additional"        => $detail_variant->additional,
                "id_optional"       => $detail_variant->id_optional,
                "optional"          => $detail_variant->optional,
                "id_satuan"         => $detail_variant->id_satuan,
                "satuan"            => $detail_variant->satuan,
                "harga"             => $detail_variant->harga,
                "jumlah"            => $av["jumlah"],
            );

            array_push($variant, $data);
        }
        
        // echo '<pre>'.print_r($variant,true).'</pre>';
        // print_r(json_encode($variant));
        // die;

        $mdata = array(
            'title'         => NAMETITLE . ' - Order',
            'content'       => 'widget/order/order',
            'extra'		    => 'widget/order/js/_js_order',
            'variant'       => $variant, 
            'all_variant'   => $all_variant,
            'address'       => $resultAddress, 
            'cabang'        => $resultCabang, 
            'token'         => $token
        );
        $this->load->view('layout/wrapper', $mdata);
	}

    public function kalkulasi_item($id, $jumlah = null)
    {
        $cookie = stripslashes($_COOKIE['variant']);
        $all_variant = json_decode($cookie, true);

        $new_variant = array();
        foreach($all_variant as $av){
            if($av['id_variant'] == $id){
                array_push($new_variant, array('id_variant' => $av['id_variant'], 'jumlah' => $jumlah));
            }else{
                array_push($new_variant, array('id_variant' => $av['id_variant'], 'jumlah' => $av['jumlah']));
            }
        }
        
        $data = json_encode($new_variant);
        setcookie('variant', "", time() - 3600);
        setcookie('variant', $data, 2147483647, "/");

        echo "SUKSES";
    }


    public function remove_item($id, $jumlah = null)
    {
        $cookie = stripslashes($_COOKIE['variant']);
        $all_variant = json_decode($cookie, true);

        $new_variant = array();
        foreach($all_variant as $av){
            if($av['id_variant'] != $id){
                array_push($new_variant, array('id_variant' => $av['id_variant'], 'jumlah' => $av['jumlah']));
            }
        }

        $data = json_encode($new_variant);
        setcookie('variant', "", time() - 3600);
        setcookie('variant', $data, 2147483647, "/");

        echo "Remove Item";
    }

    public function detail()
    {

        $cookie = stripslashes(@$_COOKIE['variant']);
        $all_variant = json_decode($cookie, true);

        // echo '<pre>'.print_r($all_variant,true).'</pre>';
        // die;

        
        $urlproduk = URLAPI . "/v1/produk/getproduk_byid?id=".$_GET['product'];
		$resultproduk = expatAPI($urlproduk)->result->messages;
        
        // echo '<pre>'.print_r($resultproduk,true).'</pre>';
        // die;

        $variantproduk = expatAPI(URLAPI . "/v1/produk/get_varianbyid?id=".$_GET['product'])->result->messages;

        $mdata = array(
            'title'         => NAMETITLE . ' - Order Detail',
            'content'       => 'widget/order/detail_order',
            'extra'		    => 'widget/order/js/_js_index',
            'product'       => $resultproduk,
            'variant'       => $variantproduk,
            'totalorder'    => @count(@$all_variant)

        );
        $this->load->view('layout/wrapper', $mdata);
    }

    public function setcookie_add_tocart()
    {
        $input = $this->input;
        $id = $this->security->xss_clean($input->post('id_variant'));
        $total = $this->security->xss_clean($input->post('total_variant'));
        $idcabang = $this->security->xss_clean($input->post('idcabang'));
        $idproduk = $this->security->xss_clean($input->post('idproduk'));
        
        
        if(isset($_COOKIE['variant'])){
            
            $cookie = stripslashes($_COOKIE['variant']);
            $variant_available = json_decode($cookie, true);
            
            
            // array_push($variant_avail, $variant_show);
            
            $mdata = array(
                "id_variant"    => $id,
                "jumlah"        => $total
            );
            
            array_push($variant_available, $mdata);

            $data = json_encode($variant_available);
            setcookie('variant', "", time() - 3600, "/");
            setcookie('variant', $data, 2147483647, "/");
            redirect('widget/order/detail?cabang='.$idcabang.'&product='.$idproduk);
        }else{
            $variant_empty = array();

            $mdata = array(
                "id_variant"    => $id,
                "jumlah"        => $total
            );

            array_push($variant_empty, $mdata);

            $data = json_encode($variant_empty);
            setcookie('variant', "", time() - 3600, "/");
            setcookie('variant', $data, 2147483647, "/");
            redirect('widget/order/detail?cabang='.$idcabang.'&product='.$idproduk);
        }

    }
    
    public function get_harga_produk()
    {
        $input = $this->input;
		$id_optional = $this->security->xss_clean($input->post('id_optional'));
		$id_satuan = $this->security->xss_clean($input->post('id_satuan'));
		$id_additional = $this->security->xss_clean($input->post('id_additional'));

        $mdata = array(
            'id_optional'   => $id_optional,
            'id_satuan'     => $id_satuan,
            'id_additional' => $id_additional
        );

        $url = URLAPI . "/v1/produk/get_varianbyid?id=".$_GET['product'];
		$result = expatAPI($url)->result->messages;
        

        $harga;
        foreach($result as $dt){        
            if($_GET['cabang'] == $dt->id_cabang){
                if(
                    $mdata['id_optional'] == $dt->id_optional && 
                    $mdata['id_satuan'] == $dt->id_satuan && 
                    $mdata['id_additional'] == $dt->id_additional
                ){
                    $datas = array(
                        "id_variant"    => $dt->id,
                        "harga"         => @$dt->harga
                    );     
                }
            }
        }

        echo json_encode(@$datas);
    }

    public function loadaddress($token)
    {
        $url = URLAPI . "/v1/mobile/order/last_address";
		$result = mobileAPI($url, $mdata=NULL, $token)->result->messages;
        echo json_encode($result);  
        die;    
    }

    
    public function addaddress($token)
    {  
        $urlAddress 		= URLAPI . "/v1/mobile/order/last_address";
		$responseAddress 	= mobileAPI($urlAddress, $mdata = NULL, $token);
        $resultAddress      = $responseAddress->result->messages;

        // echo '<pre>'.print_r($this->uri->segment('4'),true).'</pre>';


        $mdata = array(
            'title'         => NAMETITLE . ' - Add Address',
            'content'       => 'widget/address/add_address',
            // 'extra'		    => 'widget/address/js/_js_addaddress',
            'address'       => $resultAddress,
            'token'         => $token
        );

        $this->load->view('layout/wrapper', $mdata);
    }

    public function addaddress_process($token)
    {
        $input          = $this->input;
		// $token          = $this->security->xss_clean($input->post('token'));
        $idaddress      = $this->security->xss_clean($input->post('idaddress'));
		$nameaddress    = $this->security->xss_clean($input->post('nameaddress'));
		$address        = $this->security->xss_clean($input->post('address'));
		$phone          = $this->security->xss_clean($input->post('phone'));
        $idcabang       = $this->security->xss_clean($input->post('idcabang'));


        $mdata = array(
            'title'         => $nameaddress,
            'alamat'        => $address,
            'phone'         => $phone,
            'is_primary'    => 'yes'
        );

        $url = URLAPI . "/v1/mobile/order/add_address";
		$response = mobileAPI($url, json_encode($mdata), $token);
        $result = $response->result;

        if($response->status == 200){
			redirect('widget/order/ordersummary/'.$token.'?cabang='.$idcabang);
			return;
        }else{
            $this->session->set_flashdata('error', $result->messages->error);
            return;
        }

    }

    public function editaddress($token)
    {  
        $urlAddress 		= URLAPI . "/v1/mobile/order/last_address";
		$responseAddress 	= mobileAPI($urlAddress, $mdata = NULL, $token);
        $resultAddress      = $responseAddress->result->messages;

        // echo '<pre>'.print_r($this->uri->segment('4'),true).'</pre>';


        $mdata = array(
            'title'         => NAMETITLE . ' - Edit Address',
            'content'       => 'widget/address/edit_address',
            'extra'		    => 'widget/address/js/_js_editaddress',
            'address'       => $resultAddress,
            'token'         => $token
        );

        $this->load->view('layout/wrapper', $mdata);
    }

    public function editaddress_process($token)
    {
        $input          = $this->input;
		// $token          = $this->security->xss_clean($input->post('token'));
		$idaddress      = $this->security->xss_clean($input->post('idaddress'));
		$nameaddress    = $this->security->xss_clean($input->post('nameaddress'));
		$address        = $this->security->xss_clean($input->post('address'));
		$phone          = $this->security->xss_clean($input->post('phone'));
		$idcabang       = $this->security->xss_clean($input->post('idcabang'));


        $mdata = array(
            'title'         => $nameaddress,
            'alamat'        => $address,
            'phone'         => $phone,
            'is_primary'    => 'yes'
        );


        $url = URLAPI . "/v1/mobile/order/update_address?id=".$idaddress;
		$response = mobileAPI($url, json_encode($mdata), $token);
        $result = $response->result;

        if($response->status == 200){
			redirect('widget/order/ordersummary/'.$token.'?cabang='.$idcabang);
			return;
        }else{
            $this->session->set_flashdata('error', $result->messages->error);
            return;
        }
    

    }

    public function detail_process()
    {
        $input          = $this->input;
		// $idmember       = $this->security->xss_clean($input->post('id_member'));
		$idcabang       = $this->security->xss_clean($input->post('id_cabang'));
		$idvariant      = $this->security->xss_clean($input->post('id_variant'));
		$idpengiriman   = $this->security->xss_clean($input->post('idpengiriman'));
		$jumlah         = $this->security->xss_clean($input->post('jumlah'));;
		$token          = $this->security->xss_clean($input->post('usertoken'));;
		$note          = $this->security->xss_clean($input->post('inptnote'));

        $temp_item = array();

        foreach($idvariant as $keyid => $valid){
            $temp['id_varian']   = $valid; 
            foreach($jumlah as $keyjmlh => $valjmlh){
                $temp['jumlah']   = $valjmlh;
                if(($keyid == $keyjmlh) && ($keyjmlh == $keyid)){
                    array_push($temp_item, $temp);
                } 
            }
        }


        if($idpengiriman != null){
            $mdata = array(
                'id_pengiriman'  => $idpengiriman,
                'id_cabang'      => $idcabang, 
                'is_pickup'     => 'No',
                'note'          => ($note == null ? null : $note),
                'items'           => $temp_item
            );  
        }else{
            $mdata = array(
                'id_pengiriman'  => 'null',
                'id_cabang'      => $idcabang, 
                'is_pickup'     => 'Yes',
                'note'          => ($note == null ? null : $note),
                'items'           => $temp_item
            );  
        }

        // echo '<pre>'.print_r($mdata,true).'</pre>';
        // die;
        
        $url = URLAPI . "/v1/mobile/order/add_transaksi";
		$response = mobileAPI($url, json_encode($mdata), $token);
        $result = $response->result;

        if($response->status == 200){
            setcookie('variant', "", time() - 3600, "/");
			redirect('widget/order/notif/'.$token);
			return;
        }else{
            // $this->session->set_flashdata('error', $result->messages->error);
            redirect('widget/order/ordersummary/'.$token.'?cabang='.$idcabang);
            return;
        }
    }

    public function notif($token)
    {
        setcookie('variant', "", time() - 3600);
        $url = URLAPI . "/v1/mobile/order/list_transaksi";
		$response = mobileAPI($url, $mdata = NULL, $token);
        $result = $response->result->messages;

        // echo '<pre>'.print_r($result,true).'</pre>';
        // die;

        $mdata = array(
            'title'     => NAMETITLE . ' - Order Detail',
            'content'   => 'widget/order/notif',
            'extra'		=> 'widget/order/js/_js_index',

        );
        $this->load->view('layout/wrapper', $mdata);
    }
}