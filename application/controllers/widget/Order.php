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


        if(empty($all_variant)){
            echo '<pre>'.print_r("KOSONG KOOKIE",true).'</pre>';
        }

        // echo '<pre>'.print_r($all_variant,true).'</pre>';
        // die;
        // Killua BEARER TOKEN
        // bbe287cf3a3bf23306bb175c8461ce86a16f6a75

        // echo '<pre>'.print_r(getToken(),true).'</pre>';
        // die;
        // $token = 'bbe287cf3a3bf23306bb175c8461ce86a16f6a75';
        // bbe287cf3a3bf23306bb175c8461ce86a16f6a75""


        $urlAddress 		= URLAPI . "/v1/mobile/order/last_address";
		$responseAddress 	= mobileAPI($urlAddress, $mdata = NULL, $token);
        $resultAddress      = $responseAddress->result->messages;

        $urlUser 		= URLAPI . "/v1/mobile/member/get_userdetail";
		$responseUser 	= mobileAPI($urlUser, $mdata = NULL, $token);
        $resultUser      = $responseUser->result->messages;


        $urlCabang 		= URLAPI . "/v1/mobile/outlet/getcabang_byid?id=".$_GET['cabang'];
		$responseCabang 	= expatAPI($urlCabang);
        $resultCabang      = $responseCabang->result->messages;

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
            'user'          => $resultUser,
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
        setcookie('variant', "", time() - 3600, "/");
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
        setcookie('variant', "", time() - 3600, "/");
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

    public function enterpin()
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

        $this->session->set_userdata('ordersummary', $mdata);

        // echo '<pre>'.print_r($mdata,true).'</pre>';
        // echo '<pre>'.print_r($token,true).'</pre>';
        // die;
        

        
        $mdata = array(
            'title'         => NAMETITLE . ' - Enter PIN',
            'content'       => 'widget/order/enterpin',
            'extra'		    => 'widget/order/js/_js_pin',
            'token'         => $token
        );

        $this->load->view('layout/wrapper', $mdata);
        
    }

	public function getsignature($clientId, $requestDate, $requestId, $requestBody){
		$targetPath = "/checkout/v1/payment"; 
		$secretKey = "SK-KHUvvn4fm3zXRIip0UWY";

		// Generate Digest
		$digestValue = base64_encode(hash('sha256', json_encode($requestBody), true));
		
		// Prepare Signature Component
		$componentSignature = "Client-Id:" . $clientId . "\n" . 
							  "Request-Id:" . $requestId . "\n" .
							  "Request-Timestamp:" . $requestDate . "\n" . 
							  "Request-Target:" . $targetPath . "\n" .
							  "Digest:" . $digestValue;

		// Calculate HMAC-SHA256 base64 from all the components above
		$signature = base64_encode(hash_hmac('sha256', $componentSignature, $secretKey, true));
		return $signature;

	}
	
	

    public function detail_process()
    {
        $input          = $this->input;
		$enterpin       = $this->security->xss_clean($input->post('enterpin'));
		$token          = $this->security->xss_clean($input->post('usertoken'));
		$method		    = $this->security->xss_clean($input->post('methodpayment'));
		$amount         = "//amount total";
		$email          = "//customer email";
		// // $idmember       = $this->security->xss_clean($input->post('id_member'));
		// $idcabang       = $this->security->xss_clean($input->post('id_cabang'));
		// $idvariant      = $this->security->xss_clean($input->post('id_variant'));
		// $idpengiriman   = $this->security->xss_clean($input->post('idpengiriman'));
		// $jumlah         = $this->security->xss_clean($input->post('jumlah'));;
		// $note          = $this->security->xss_clean($input->post('inptnote'));

        // $temp_item = array();

        // foreach($idvariant as $keyid => $valid){
        //     $temp['id_varian']   = $valid; 
        //     foreach($jumlah as $keyjmlh => $valjmlh){
        //         $temp['jumlah']   = $valjmlh;
        //         if(($keyid == $keyjmlh) && ($keyjmlh == $keyid)){
        //             array_push($temp_item, $temp);
        //         } 
        //     }
        // }


        // if($idpengiriman != null){
        //     $mdata = array(
        //         'id_pengiriman'  => $idpengiriman,
        //         'id_cabang'      => $idcabang, 
        //         'is_pickup'     => 'No',
        //         'note'          => ($note == null ? null : $note),
        //         'items'           => $temp_item
        //     );  
        // }else{
        //     $mdata = array(
        //         'id_pengiriman'  => 'null',
        //         'id_cabang'      => $idcabang, 
        //         'is_pickup'     => 'Yes',
        //         'note'          => ($note == null ? null : $note),
        //         'items'           => $temp_item
        //     );  
        // }
        

        if(!empty($enterpin)){

            $pin = array(
                "pin"   => sha1($enterpin)
            );

            $url = URLAPI . "/v1/mobile/member/check_pin";
            $response = mobileAPI($url,  json_encode($pin), $token);
            $result = $response->result;

            if($result->status == 200){
                if(!empty($_SESSION['ordersummary'])){
                    $url = URLAPI . "/v1/mobile/order/add_transaksi";
                    $response = mobileAPI($url, json_encode($_SESSION['ordersummary']), $token);
                    $result = $response->result;
            
                    if($response->status == 200){


		
                		$invoiceID	= $response->messages;
                		//echo "<pre>".print_r($_POST,true)."</pre>";
                		if ($method=="credit"){
                			$bodyreq = array (
                						'order' => array (
                							'amount' 		 => $amount+($amount*0.03),
                							'invoice_number' => $invoiceID,
                							'currency' 		 => 'IDR',
                							'callback_url' 	 => base_url()."widget/order/success".$token,
                							"callback_url_cancel"	=> base_url()."widget/order/cancel",
                							"auto_redirect"			=> true,
                							"disable_retry_payment" => true,
                						),
                						"customer" => array(
                							  "email"	=> $email,
                						),				
                						'payment' => array (
                							'payment_due_date' => 60,
                							"payment_method_types" => [
                								"CREDIT_CARD"
                							]
                						),
                			);
                		}elseif ($method=="virtual"){
                			$bodyreq = array (
                						'order' => array (
                							'amount' 		 => $amount,
                							'invoice_number' => $invoiceID,
                							'currency' 		 => 'IDR',
                							'callback_url' 	 => base_url()."widget/order/success".$token,
                							"callback_url_cancel"	=> base_url()."widget/order/cancel",
                							"auto_redirect"			=> true,
                							"disable_retry_payment" => true,
                						),
                						"customer" => array(
                							  "email"	=> $email,
                						),				
                						'payment' => array (
                							'payment_due_date' => 60,
                							"payment_method_types" => [
                								"VIRTUAL_ACCOUNT_BCA",
                								"VIRTUAL_ACCOUNT_BANK_MANDIRI",
                								"VIRTUAL_ACCOUNT_BANK_SYARIAH_MANDIRI",
                								"VIRTUAL_ACCOUNT_DOKU",
                								"VIRTUAL_ACCOUNT_BRI",
                								"VIRTUAL_ACCOUNT_BNI",
                								"VIRTUAL_ACCOUNT_BANK_PERMATA",
                								"VIRTUAL_ACCOUNT_BANK_CIMB",
                								"VIRTUAL_ACCOUNT_BANK_DANAMON"
                							]
                						),
                			);
                		}elseif($method=="wallet"){
                			$bodyreq = array (
                						'order' => array (
                							'amount' 		 => $amount,
                							'invoice_number' => $invoiceID,
                							'currency' 		 => 'IDR',
                							'callback_url' 	 => base_url()."widget/order/success".$token,
                							"callback_url_cancel"	=> base_url()."widget/order/cancel",
                							"auto_redirect"			=> true,
                							"disable_retry_payment" => true,
                						),
                						"customer" => array(
                							  "email"	=> $email,
                						),				
                						'payment' => array (
                							'payment_due_date' => 60,
                							"payment_method_types" => [
                								"EMONEY_SHOPEEPAY",
                							  	"EMONEY_OVO",
                							  	"EMONEY_DANA",
                							]
                						),
                			);
                		}else{
                			$bodyreq = array (
                						'order' => array (
                							'amount' 		 => $amount,
                							'invoice_number' => $invoiceID,
                							'currency' 		 => 'IDR',
                							'callback_url' 	 => base_url()."widget/order/success".$token,
                							"callback_url_cancel"	=> base_url()."widget/order/cancel",
                							"auto_redirect"			=> true,
                							"disable_retry_payment" => true,
                						),
                						"customer" => array(
                							  "email"	=> $email,
                						),				
                						'payment' => array (
                							'payment_due_date' => 60,
                							"payment_method_types" => [
                								"QRIS",
                							]
                						),
                			);
                		}
                
                		$clientID		= "MCH-1352-1634273860130";
                		$dateTime 		= gmdate("Y-m-d H:i:s");
                		$isoDateTime 	= date(DATE_ISO8601, strtotime($dateTime));
                		$requestTime 	= substr($isoDateTime, 0, 19) . "Z";
                		$requestID		= time().uniqid();

                		$signature = $this->getsignature($clientID, $requestTime, $requestID, $bodyreq);
                		$url	= "https://api-sandbox.doku.com/checkout/v1/payment";
                		$ch = curl_init($url);
                		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($bodyreq));
                		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                
                		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                			'Content-Type: application/json',
                			'Client-Id:' . $clientID,
                			'Request-Id:' . $requestID,
                			'Request-Timestamp:' . $requestTime,
                			'Signature:' . "HMACSHA256=" . $signature,
                		));
                
                		// Set response json
                		$result = json_decode(curl_exec($ch));
                		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                
                		curl_close($ch);
                        setcookie('variant', "", time() - 3600, "/");
                		//echo "<pre>".print_r($result,true)."</pre>";
                		//die;
                		if ($result->message[0]=="SUCCESS"){
                			redirect($result->response->payment->url);
                		}else{
                			$this->session->set_flashdata("error","Your topup cannot be processed");
                			redirect(base_url()."widget/topup/membertopup/".$token);
                		}
                    }else{
                        redirect('widget/order/ordersummary/'.$token.'?cabang='.$idcabang);
                        return;
                    }
                }
            }else{
                $this->session->set_flashdata('error', $result->messages->error);
                return;
            }
        }else{
            $this->session->set_flashdata('error', $result->messages->error);
            return;
        }
    }


    public function removecookie()
    {
        setcookie('variant', "", time() - 3600, "/");
    }

    public function notif($token)
    {
        setcookie('variant', "", time() - 3600, "/");
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