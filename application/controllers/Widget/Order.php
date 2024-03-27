<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{	
        $cookie = stripslashes($_COOKIE['variant']);
        $all_variant = json_decode($cookie, true);

        // echo '<pre>'.print_r($all_variant,true).'</pre>';
        // die;

        $variant = array();
        foreach($all_variant as $av){
            $detail_variant = expatAPI(URLAPI . "/v1/produk/get_detailbyid?id=".$av['id_variant'])->result->messages;
            $detail_produk  = expatAPI(URLAPI . "/v1/produk/getproduk_byid?id=".$detail_variant->id_produk)->result->messages;
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
            'title'     => NAMETITLE . ' - Order',
            'content'   => 'widget/order/order',
            'extra'		=> 'widget/order/js/_js_order',
            'variant'   => $variant, 
            'all_variant'  => $all_variant
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

    public function detail()
    {

        $urlproduk = URLAPI . "/v1/produk/getproduk_byid?id=".$_GET['produk'];
		$resultproduk = expatAPI($urlproduk)->result->messages;


        $variantproduk = expatAPI(URLAPI . "/v1/produk/get_varianbyid?id=".$_GET['produk'])->result->messages;
		// $resultoptional = expatAPI($urloptional)->result->messages;

        // echo '<pre>'.print_r($variantproduk,true).'</pre>';
        // print_r(json_encode($variantproduk));
        // die;

        // $cart_final = array();
        // $cart = array(
        //     'idvariant' =>  1,
        //     'jumlah' =>  10
        // );

        // array_push($cart_final, $cart);
        
        // $cart2 = array(
        //     'idvariant' =>  1,
        //     'jumlah' =>  10
        // );
        
        // array_push($cart_final, $cart2);

        // $json = json_encode($cart_final);
        // setcookie('variant', $json);


        // $cookie = $_COOKIE['variant'];
        // $cookie = stripslashes($cookie);
        // $cart_show = json_decode($cookie, true);

        // array_push($cart_show, $cart3);

        // echo '<pre>'.print_r($json,true).'</pre>';
        // echo '<pre>'.print_r( $cart_show,true).'</pre>';
        // die;




        $mdata = array(
            'title'     => NAMETITLE . ' - Order Detail',
            'content'   => 'widget/order/detail_order',
            'extra'		=> 'widget/order/js/_js_index',
            'produk'    => $resultproduk,
            'variant'   => $variantproduk

        );
        $this->load->view('layout/wrapper', $mdata);
    }

    public function setcookie_add_tocart()
    {
        $input = $this->input;
        $id = $this->security->xss_clean($input->post('id_variant'));
        $total = $this->security->xss_clean($input->post('total_variant'));
        
        
        if(isset($_COOKIE['variant'])){
            
            $cookie = stripslashes($_COOKIE['variant']);
            $variant_available = json_decode($cookie, true);
            
            
            // array_push($variant_avail, $variant_show);
            echo '<pre>'.print_r($variant_available,true).'</pre>';
            
            $mdata = array(
                "id_variant"    => $id,
                "jumlah"        => $total
            );
            
            array_push($variant_available, $mdata);

            $data = json_encode($variant_available);
            setcookie('variant', "", time() - 3600);
            setcookie('variant', $data, 2147483647, "/");

            redirect('widget/order');
            // echo '<pre>'.print_r($variant_show,true).'</pre>';
            // die;
        }else{
            $variant_empty = array();

            $mdata = array(
                "id_variant"    => $id,
                "jumlah"        => $total
            );

            array_push($variant_empty, $mdata);

            $data = json_encode($variant_empty);
            setcookie('variant', "", time() - 3600);
            setcookie('variant', $data, 2147483647, "/");
            redirect('widget/order');
        }



        

        // $data = json_encode($cart_final);
        // setcookie('variant', "", time() - 3600);
        // setcookie('variant', $data, 2147483647);
        // redirect('widget/order/add_tocart');
    }
    
    // public function add_tocart()
    // {

    //     $cookie = stripslashes($_COOKIE['variant']);
    //     $variant_show = json_decode($cookie, true);

    //     echo '<pre>'.print_r($variant_show,true).'</pre>';
    //     die;
    // }

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

        $url = URLAPI . "/v1/produk/get_varianbyid?id=".$_GET['produk'];
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

    public function detail_process()
    {
        $input = $this->input;
		$idvariant   = $this->security->xss_clean($input->post('id_variant'));
		$cartdelivery   = $this->security->xss_clean($input->post('cartdelivery'));
		$jumlah         = $this->security->xss_clean($input->post('jumlah'));
		// $cupsize = $this->security->xss_clean($input->post('cupsize'));
		// $shot = $this->security->xss_clean($input->post('shot'));
		// $injumlahcoffe = $this->security->xss_clean($input->post('injumlahcoffe'));

        $temp_item = array();

        foreach($idvariant as $keyid => $valid){
            $temp['id_variant']   = $valid; 
            foreach($jumlah as $keyjmlh => $valjmlh){
                $temp['jumlah']   = $valjmlh;
                if(($keyid == $keyjmlh) && ($keyjmlh == $keyid)){
                    array_push($temp_item, $temp);
                } 
            }
        }

        echo '<pre>'.print_r($idvariant,true).'</pre>';
        echo '<pre>'.print_r($jumlah,true).'</pre>';

        $mdata = array(
            'cartdelivery'  => $cartdelivery,
            'items'          => $temp_item
            // 'shot'          => $shot,
            // 'jumlahcoffe'   => $injumlahcoffe
        );  

        echo '<pre>'.print_r($mdata,true).'</pre>';
        die;
    }
	
}