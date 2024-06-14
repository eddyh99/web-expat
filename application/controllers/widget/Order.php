<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*----------------------------------------------------------
    Modul Name  : Order
    Desc        : Modul ini di gunakan untuk menampilkan webview dari flutter saat melakukan
                  menambahkan produk to cart, order transaksi, enterpin, serta proses doku
                  
    Sub fungsi  : 
    - ordersummary          : Tampilan order summary produk user
    - kalkulasi_item  	    : Prosess menambahkan atau mengurangi produk di halaman ordersummary
    - remove_item           : Menghapus cookie produk yang kurang dar 1
    - detail  			    : Tampilan detail produk berupa, option, size, additional dan add to cart
    - setcookie_add_tocart  : Set cookie user add to cart detail produk
    - get_harga_produk      : Tampilan harga produk di halaman detail produk
    - loadaddress           : Get data address user from API
    - addaddress            : Tampilan tambah alamat user
    - addaddress_process    : Proses menambahkan alamat user
    - editaddress           : Tampilan mengubah alamat user
    - editaddress_process   : Proses mengupdate alamat user
    - enterpin              : Tampilan enterpin dan proses DOKU
    - cancel                : Redirecy cancel DOKU
    - getsignature          : Proses get signature
    - detail_process        : Proses add transkasi setelah enterpin expatbalance metod
    - removecookie          : Hapus cookie dan session
    - notif                 : Tampilan halaman berhasil order
------------------------------------------------------------*/ 

class Order extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

    private function getFastestRoute($origin, $destination) {
        $apiKey = 'AIzaSyAHJmWb8cmOV3QMTtc561XdQuc3ems19Jw';
        $url = 'https://maps.googleapis.com/maps/api/directions/json';
        $params = [
            'origin' => $origin,
            'destination' => $destination,
            'key' => $apiKey,
            'mode' => 'driving',  // Change to desired mode of transport
            'departure_time' => 'now',  // Use 'now' to get real-time traffic information
            'units' => 'metric'  // Specify metric units for distance in kilometers
        ];
        
        $url .= '?' . http_build_query($params);
        
        // Initialize a CURL session.
        $ch = curl_init();
        
        // Return Page contents.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        // Set the URL
        curl_setopt($ch, CURLOPT_URL, $url);
        
        // Execute the session and store the contents in $response
        $response = curl_exec($ch);
        
        // Closing the session
        curl_close($ch);
        
        // Decode the JSON response
        $directions = json_decode($response, true);
        
        if ($directions['status'] == 'OK') {
            $route = $directions['routes'][0];
            return $route;
        } else {
            return null;
        }
    }
    
    //@todo display error to summary
	public function ordersummary($token)
	{	
        // Get Cookie
        $cookie = stripslashes($_COOKIE['variant']);
        $all_variant = json_decode($cookie, true);
        // echo '<pre>'.print_r($all_variant,true).'</pre>';
        
        // Get Alamat user
        $urlAddress 		= URLAPI . "/v1/mobile/order/last_address";
		$responseAddress 	= mobileAPI($urlAddress, $mdata = NULL, $token);
        $resultAddress      = $responseAddress->result->messages;

        // echo '<pre>'.print_r($resultAddress,true).'</pre>';
        // die;
        // Get User detail
        $urlUser 		= URLAPI . "/v1/mobile/member/get_userdetail";
		$responseUser 	= mobileAPI($urlUser, $mdata = NULL, $token);
        $resultUser      = $responseUser->result->messages;
        
        
        // Get Cabang
        $urlCabang 		= URLAPI . "/v1/mobile/outlet/getcabang_byid?id=".$_GET['cabang'];
		$responseCabang 	= expatAPI($urlCabang);
        $resultCabang      = $responseCabang->result->messages;
        // echo '<pre>'.print_r($resultCabang,true).'</pre>';
        // die;
        
        $origin = $resultAddress->address->latitude.','.$resultAddress->address->longitude;  // Latitude and longitude for origin
        $destination = $resultCabang->latitude.','.$resultCabang->longitude;  // Latitude and longitude for destination
        // echo $origin;
        // echo "<hr>";
        // echo $destination;
        // die;
        $route = $this->getFastestRoute($origin, $destination);
        
        if ($route) {
            $legs = $route['legs'][0];
            $distance = $legs['distance'];
            $jarak = str_replace(' km', '', $distance['text']);  // Remove " km" from the distance text
            if ($jarak>$resultCabang->max){
                $error = "Delivery Address is too far, max is ".$distance['text'];
            }
        } else {
            $error = "No route found";
        }
        
        //display error
                
        // Cek Detail Variant dan produk
        // Assign ke new array
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
        // Get Cookie
        $cookie = stripslashes($_COOKIE['variant']);
        $all_variant = json_decode($cookie, true);

        // Kalkulasi Item 
        // Replace jumlah produk yang di pilih
        $new_variant = array();
        foreach($all_variant as $av){
            if($av['id_variant'] == $id){
                array_push($new_variant, array('id_variant' => $av['id_variant'], 'jumlah' => $jumlah));
            }else{
                array_push($new_variant, array('id_variant' => $av['id_variant'], 'jumlah' => $av['jumlah']));
            }
        }
        
        // Set Cookie
        $data = json_encode($new_variant);
        setcookie('variant', "", time() - 3600, "/");
        setcookie('variant', $data, 2147483647, "/");

        echo "SUKSES";
    }


    public function remove_item($id, $jumlah = null)
    {
        // Get Cookie
        $cookie = stripslashes($_COOKIE['variant']);
        $all_variant = json_decode($cookie, true);

        // Menyesuikan array baru dengan kalkulasi
        $new_variant = array();
        foreach($all_variant as $av){
            if($av['id_variant'] != $id){
                array_push($new_variant, array('id_variant' => $av['id_variant'], 'jumlah' => $av['jumlah']));
            }
        }

        // Set Cookie
        $data = json_encode($new_variant);
        setcookie('variant', "", time() - 3600, "/");
        setcookie('variant', $data, 2147483647, "/");

        echo "Remove Item";
    }

    public function detail()
    {

        // Get Cookie
        $cookie = stripslashes(@$_COOKIE['variant']);
        $all_variant = json_decode($cookie, true);
        
        // Get Produk by id
        $urlproduk = URLAPI . "/v1/produk/getproduk_byid?id=".$_GET['product'];
		$resultproduk = expatAPI($urlproduk)->result->messages;
        
        // Get Variant produk
        $variantproduk = expatAPI(URLAPI . "/v1/produk/get_varianbyid?id=".$_GET['product'])->result->messages;
        // print_r(json_encode($variantproduk));
        // die;
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
            // Check ketika cookie tidak kosong
            $cookie = stripslashes($_COOKIE['variant']);
            $variant_available = json_decode($cookie, true);
            
            // Mencari produk dan variant yang sama &
            // Replace cookie yang sudah ada dengan jumlah yang baru
            foreach($variant_available as $key => $val){
                if($val['id_variant'] == $id){
                    $total += $val['jumlah'];
                    $mdata = array(
                        "id_variant"    => $val['id_variant'],
                        "jumlah"        => $total
                    );
                    unset($variant_available[$key]);
                    array_push($variant_available, $mdata);
                    
                    $newarr = array_values($variant_available);
                    $data = json_encode($newarr);
                    setcookie('variant', "", time() - 3600, "/");
                    setcookie('variant', $data, 2147483647, "/");
                    redirect('widget/order/detail?cabang='.$idcabang.'&product='.$idproduk);
                }
            }

            
            // Tambahkan produk dan variant baru
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
            // Check cookie ketika kosong
            // Tambahkan produk dan variant baru
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

        // Assign variabel ke dalam array
        $mdata = array(
            'id_optional'   => $id_optional,
            'id_satuan'     => $id_satuan,
            'id_additional' => $id_additional
        );

        // Get variant by id produk
        $url = URLAPI . "/v1/produk/get_varianbyid?id=".$_GET['product'];
		$result = expatAPI($url)->result->messages;
        

        // Cek apakah produk dan variant sesuai dengan dipilih user
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
        // Get Address
        $url = URLAPI . "/v1/mobile/order/last_address";
		$result = mobileAPI($url, $mdata=NULL, $token)->result->messages->address;
        echo json_encode($result);  
        die;    
    }

    
    public function addaddress($token)
    {  
        // Get Last Address
        $urlAddress 		= URLAPI . "/v1/mobile/order/last_address";
		$responseAddress 	= mobileAPI($urlAddress, $mdata = NULL, $token);
        $resultAddress      = $responseAddress->result->messages;

        // echo '<pre>'.print_r($resultAddress,true).'</pre>';
        // die;
        $mdata = array(
            'title'         => NAMETITLE . ' - Add Address',
            'content'       => 'widget/address/add_address',
            'extra'         => 'widget/address/js/_js_addaddress',
            'address'       => $resultAddress,
            'token'         => $token
        );

        $this->load->view('layout/wrapper', $mdata);
    }

    public function addaddress_process($token)
    {
        $input          = $this->input;
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

        // Post data add address
        $url = URLAPI . "/v1/mobile/order/add_address";
		$response = mobileAPI($url, json_encode($mdata), $token);
        $result = $response->result;

        // Resposnse Data add address
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
        // Get Last Address
        $urlAddress 		= URLAPI . "/v1/mobile/order/last_address";
		$responseAddress 	= mobileAPI($urlAddress, $mdata = NULL, $token);
        $resultAddress      = $responseAddress->result->messages->address;

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
		$idaddress      = $this->security->xss_clean($input->post('idaddress'));
		$nameaddress    = $this->security->xss_clean($input->post('nameaddress'));
		$address        = $this->security->xss_clean($input->post('address'));
		$phone          = $this->security->xss_clean($input->post('phone'));
		$idcabang       = $this->security->xss_clean($input->post('idcabang'));
		$pacinput       = $this->security->xss_clean($input->post('pac-input'));

        $mdata = array(
            'title'         => $nameaddress,
            'alamat'        => $address,
            'phone'         => $phone,
            'is_primary'    => 'yes'
        );

        // Post Data edit address
        $url = URLAPI . "/v1/mobile/order/update_address?id=".$idaddress;
		$response = mobileAPI($url, json_encode($mdata), $token);
        $result = $response->result;

        // Resposnse Data edit address
        if($response->status == 200){
			redirect('widget/order/ordersummary/'.$token.'?cabang='.$idcabang);
			return;
        }else{
            $this->session->set_flashdata('error', $result->messages->error);
            return;
        }

    }

    //@todo redirect ke order summary
    public function enterpin()
    {
        // Get Data from user
        $input          = $this->input;
		$idcabang       = $this->security->xss_clean($input->post('id_cabang'));
		$idvariant      = $this->security->xss_clean($input->post('id_variant'));
		$idpengiriman   = $this->security->xss_clean($input->post('idpengiriman'));
		$jumlah         = $this->security->xss_clean($input->post('jumlah'));
		$token          = $this->security->xss_clean($input->post('usertoken'));
		$note           = $this->security->xss_clean($input->post('inptnote'));
        $method		    = "expatbalance";
        $amount         = $this->security->xss_clean($input->post('amount'));
        $saldo          = $this->security->xss_clean($input->post('saldo'));

        // Get Alamat user
        $urlAddress 		= URLAPI . "/v1/mobile/order/last_address";
		$responseAddress 	= mobileAPI($urlAddress, $mdata = NULL, $token);
        $resultAddress      = $responseAddress->result->messages;
        
        // Get Cabang
        $urlCabang 		= URLAPI . "/v1/mobile/outlet/getcabang_byid?id=".$_GET['cabang'];
		$responseCabang 	= expatAPI($urlCabang);
        $resultCabang      = $responseCabang->result->messages;
        // echo '<pre>'.print_r($resultCabang,true).'</pre>';
        // die;
        
        $origin = $resultAddress->address->latitude.','.$resultAddress->address->longitude;  // Latitude and longitude for origin
        $destination = $resultCabang->latitude.','.$resultCabang->longitude;  // Latitude and longitude for destination
        // echo $origin;
        // echo "<hr>";
        // echo $destination;
        // die;
        $route = $this->getFastestRoute($origin, $destination);
        
        if ($route) {
            $legs = $route['legs'][0];
            $distance = $legs['distance'];
            $jarak = str_replace(' km', '', $distance['text']);  // Remove " km" from the distance text
            if ($jarak>$resultCabang->max){
                $error = "Delivery Address is too far, max is ".$distance['text'];
                //redirect order summary
            }
        } else {
            $error = "No route found";
            //redirect order summary
        }


        // Get variant user dan ubah bentuk array
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

        
        // Assign data user ke array
        $mdata = array(
            'id_pengiriman'     => (($idpengiriman != null) ? $idpengiriman : null),
            'id_cabang'         => $idcabang, 
            'is_pickup'         => (($idpengiriman != null) ? 'No' : 'Yes'),
            'note'              => ($note == null ? null : $note),
            'carabayar'         => $method,
            'items'             => $temp_item
        );

        /*
        echo '<pre>'.print_r($mdata,true).'</pre>';
        die;
        */
        
        // Set Session Ordersummary
        $this->session->set_userdata('ordersummary', $mdata);


        if($method != 'expatbalance'){
            // Pengecekan jika tidak menggunakan expatbalance

            // POST add transaksi
            $url = URLAPI . "/v1/mobile/order/add_transaksi";
            $response = mobileAPI($url, json_encode($mdata), $token);
            $result = $response->result;

            // Response add transaksi 
            if($response->status == 200){
                $invoiceID	= $result->messages;
                if ($method=="credit"){

                    // Jika menggunakan Credit Card
                    $bodyreq = array (
                                'order' => array (
                                    'amount' 		 => $amount+($amount*0.03),
                                    'invoice_number' => $invoiceID,
                                    'currency' 		 => 'IDR',
                                    'callback_url' 	 => base_url()."widget/order/notif/".$token,
                                    "callback_url_cancel"	=> base_url()."widget/order/cancel",
                                    "auto_redirect"			=> true,
                                    "disable_retry_payment" => true,
                                ),			
                                'payment' => array (
                                    'payment_due_date' => 60,
                                    "payment_method_types" => [
                                        "CREDIT_CARD"
                                    ]
                                ),
                    );
                }elseif ($method=="virtual"){

                    // Jika menggunakan Virtual Account
                    $bodyreq = array (
                                'order' => array (
                                    'amount' 		 => $amount,
                                    'invoice_number' => $invoiceID,
                                    'currency' 		 => 'IDR',
                                    'callback_url' 	 => base_url()."widget/order/notif/".$token,
                                    "callback_url_cancel"	=> base_url()."widget/order/cancel",
                                    "auto_redirect"			=> true,
                                    "disable_retry_payment" => true,
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

                    // Jika menggunakan E-Wallet
                    $bodyreq = array (
                                'order' => array (
                                    'amount' 		 => $amount,
                                    'invoice_number' => $invoiceID,
                                    'currency' 		 => 'IDR',
                                    'callback_url' 	 => base_url()."widget/order/notif/".$token,
                                    "callback_url_cancel"	=> base_url()."widget/order/cancel",
                                    "auto_redirect"			=> true,
                                    "disable_retry_payment" => true,
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

                    // Jika menggunakan QRIS
                    $bodyreq = array (
                                'order' => array (
                                    'amount' 		 => $amount,
                                    'invoice_number' => $invoiceID,
                                    'currency' 		 => 'IDR',
                                    'callback_url' 	 => base_url()."widget/order/notif/".$token,
                                    "callback_url_cancel"	=> base_url()."widget/order/cancel",
                                    "auto_redirect"			=> true,
                                    "disable_retry_payment" => true,
                                ),			
                                'payment' => array (
                                    'payment_due_date' => 60,
                                    "payment_method_types" => [
                                        "QRIS",
                                    ]
                                ),
                    );
                }
        
                // PROSES DOKU
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
                // setcookie('variant', "", time() - 3600, "/");

                // Response DOKU
                if ($result->message[0]=="SUCCESS"){
                    redirect($result->response->payment->url);
                }else{
                    $this->session->set_flashdata("error","Your order cannot be processed");
                    redirect("widget/order/ordersummary/".$token."?cabang=".$idcabang);
                }
            } else {
                $this->session->set_flashdata('error', $result->messages->error);
                redirect("widget/order/ordersummary/".$token."?cabang=".$idcabang);
                return;
            }
        }

        // Jika menggunakan Expatbalance akan tetap berada di halaman enterpin
        // Cek jika saldo kurang dari total pembayaran
        if($saldo < $amount){
            $this->session->set_flashdata('error', "Your balance is not enough, please topup first or change the method payment.");
            redirect("widget/order/ordersummary/".$token."?cabang=".$idcabang);
            return;
        }
        
        $mdata = array(
            'title'         => NAMETITLE . ' - Enter PIN',
            'content'       => 'widget/order/enterpin',
            'extra'		    => 'widget/order/js/_js_pin',
            'token'         => $token,
            'id_cabang'     => $idcabang
        );

        $this->load->view('layout/wrapper', $mdata);
        
    }

    public function cancel()
	{
        // Proses cancel DOKU
		$this->session->set_flashdata("error","Your topup cannot be processed");
		redirect("widget/order/ordersummary/".$token);
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
        $idcabang       = $this->security->xss_clean($input->post('id_cabang'));
        

        if(!empty($enterpin)){
            // Cek pin tidak kosong

            // Assign pin ke dalam array dan Encryption 
            $pin = array(
                "pin"   => sha1($enterpin)
            );

            // Post cek pin kembali
            $urlpin = URLAPI . "/v1/mobile/member/check_pin";
            $response = mobileAPI($urlpin,  json_encode($pin), $token);
            $result = $response->result;

            // Response Cek PIN
            if($result->status == 200){

                if(!empty($_SESSION['ordersummary'])){
                    // Cek jika session ordersummary tidak kosong

                    // Post add transaksi
                    $url = URLAPI . "/v1/mobile/order/add_transaksi";
                    $response = mobileAPI($url, json_encode($_SESSION['ordersummary']), $token);
                    $result = $response->result;

                    // Response add transkasi
                    if($response->status == 200){
                        redirect('widget/order/notif');
                    }

                }
            }else{
                $this->session->set_flashdata('error', "Your Product Empty, please try to order");
                redirect("widget/order/ordersummary/".$token."?cabang=".$idcabang);
                return;
            }
        }else{
            $this->session->set_flashdata('error', $result->messages->error);
            return;
        }
    }


    public function removecookie()
    {
        // Remove Cookie dan session
        setcookie('variant', "", time() - 3600, "/");
        $this->session->sess_destroy();
    }

    public function notif($token = NULL)
    {
        // Remove cookie dan session
        setcookie('variant', "", time() - 3600, "/");
        $this->session->sess_destroy();


        // $url = URLAPI . "/v1/mobile/order/list_transaksi";
		// $response = mobileAPI($url, $mdata = NULL, $token);
        // $result = $response->result->messages;

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