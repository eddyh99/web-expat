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
    


	public function ordersummary($token)
	{	
        // Get Cookie
        $cookie = stripslashes($_COOKIE['cartexpat']);
        $cart = json_decode($cookie, true);

        // echo '<pre>'.print_r($cart,true).'</pre>';
        // die;
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
        
        $origin = @$resultAddress->address->latitude.','.@$resultAddress->address->longitude;  // Latitude and longitude for origin
        $destination = @$resultCabang->latitude.','.$resultCabang->longitude;  // Latitude and longitude for destination

        $route = $this->getFastestRoute($origin, $destination);
        
        if ($route) {
            $legs = $route['legs'][0];
            $distance = $legs['distance'];
            $jarak = str_replace(' km', '', $distance['text']);  // Remove " km" from the distance text
            if ($jarak > $resultCabang->max){
                $error = "Delivery Address is too far, max is ".$resultCabang->max ."km";
                $this->session->set_flashdata('warning_maxarea', $error);
            }
        } else {
            $error = "No route found";
            $this->session->set_flashdata('warning_maxarea', $error);
        }
        
        //display error
                
        // Cek Detail Optional, Additional, Satuan dan Produk
        // Assign ke new array
        $selected_product = array();
        foreach($cart as $ct){

            $product = expatAPI(URLAPI . "/v1/produk/getproduk_byid?id=".$ct['idproduk'])->result->messages;
            $show_opt = expatAPI(URLAPI . "/v1/optional/getoptional_byid?id=".$ct['idoptional'])->result->messages;
            $show_st = expatAPI(URLAPI . "/v1/satuan/getsatuan_byid?id=".$ct['idsatuan'])->result->messages;
            $show_ad = expatAPI(URLAPI . "/v1/additional/getadditional_byid?id=".$ct['idadditional'])->result->messages;

            $price_product = ($product->price + $ct['price_optional'] +$ct['price_satuan'] + $ct['price_additional']);
            $data =  (object) array(
                "id_produk"         => $ct['idproduk'],
                "picture"           => $product->picture,
                "nama"              => $product->nama,
                "quantity"          => $ct['jumlah'],
                "optional_detail"   => ((empty($show_opt)) ? null :
                    (object) array(
                        "id_opt"    => $show_opt->id,
                        "sku"       => $show_opt->sku,
                        "optional"  => $show_opt->optional,
                        "price"     => $show_opt->price,
                    )
                ),
                "satuan_detail"   => ((empty($show_st)) ? null :  
                    (object) array(
                        "id_st"     => $show_st->id,
                        "sku"       => $show_st->sku,
                        "satuan"    => $show_st->satuan,
                        "price"     => $show_st->price,
                    )
                ),
                "additional_detail"   => ((empty($show_ad)) ? null :  
                    (object) array(
                        "id_ad"     => $show_ad->id,
                        "sku"       => $show_ad->sku,
                        "additional"=> $show_ad->additional,
                        "price"     => $show_ad->price,
                    )
                ),
                "price"   => $price_product,
            );

            array_push($selected_product, $data);
        }


        $mdata = array(
            'title'         => NAMETITLE . ' - Order',
            'content'       => 'widget/order/order',
            'extra'		    => 'widget/order/js/_js_order',
            'selected_product'  => $selected_product,
            'address'       => $resultAddress, 
            'cartexpat'     => $cart,
            'cabang'        => $resultCabang, 
            'user'          => $resultUser,
            'token'         => $token
        );
        $this->load->view('layout/wrapper', $mdata);
	}

    public function kalkulasi_item($id, $jumlah = null)
    {
        // Get Cookie
        $cookie = stripslashes($_COOKIE['cartexpat']);
        $cart = json_decode($cookie, true);


        // Kalkulasi Item 
        // Replace jumlah produk yang di pilih
        $new_cart = array();
        foreach($cart as $key => $ct){
            if($key == $id){
                array_push($new_cart, 
                    array(
                        "idproduk" => $ct["idproduk"],
                        "idoptional" => $ct["idoptional"],
                        "price_optional" => $ct["price_optional"],
                        "idsatuan" => $ct["idsatuan"],
                        "price_satuan" => $ct["price_satuan"],
                        "idadditional" => $ct["idadditional"],
                        "price_additional" => $ct["price_additional"],
                        'jumlah' => $jumlah,
                    )
                );
            }else{
                array_push($new_cart, 
                    array(
                        "idproduk" => $ct["idproduk"],
                        "idoptional" => $ct["idoptional"],
                        "price_optional" => $ct["price_optional"],
                        "idsatuan" => $ct["idsatuan"],
                        "price_satuan" => $ct["price_satuan"],
                        "idadditional" => $ct["idadditional"],
                        "price_additional" => $ct["price_additional"],
                        'jumlah' => $ct["jumlah"],
                    )
                );
            }
        }
        
        // Set Cookie
        $data = json_encode($new_cart);
        setcookie('cartexpat', "", time() - 3600, "/");
        setcookie('cartexpat', $data, 2147483647, "/");

        echo "SUKSES";
    }


    public function remove_item($id, $jumlah = null)
    {
        // Get Cookie
        $cookie = stripslashes($_COOKIE['cartexpat']);
        $cart = json_decode($cookie, true);

        // Menyesuikan array baru dengan kalkulasi
        $new_cart = array();
        foreach($cart as $key => $ct){
            if($key != $id){
                array_push($new_cart, 
                    array(
                        "idproduk" => $ct["idproduk"],
                        "idoptional" => $ct["idoptional"],
                        "price_optional" => $ct["price_optional"],
                        "idsatuan" => $ct["idsatuan"],
                        "price_satuan" => $ct["price_satuan"],
                        "idadditional" => $ct["idadditional"],
                        "price_additional" => $ct["price_additional"],
                        'jumlah' => $ct["jumlah"],
                    )
                );
            }
        }

        // Set Cookie
        $data = json_encode($new_cart);
        setcookie('cartexpat', "", time() - 3600, "/");
        setcookie('cartexpat', $data, 2147483647, "/");
        echo "Remove Item";
    }

    public function detail()
    {

        // Get Cookie
        $cookie = stripslashes(@$_COOKIE['cartexpat']);
        $cart = json_decode($cookie, true);

        // echo '<pre>'.print_r($cart,true).'</pre>';
        // die;
        
        // Get Produk by id
        $urlproduk = URLAPI . "/v1/produk/getproduk_byid?id=".$_GET['product'];
		$resultproduk = expatAPI($urlproduk)->result->messages;


        $optional    = ((empty($resultproduk->optional)) ? null : explode(",", $resultproduk->optional));
        $new_opt = array();
        if(!empty($optional)){
            foreach($optional as $op){
                $temp_opt = expatAPI(URLAPI . "/v1/optional/getoptional_byid?id=".$op)->result->messages;
                array_push($new_opt, $temp_opt);
            }
        }


        $satuan    = ((empty($resultproduk->satuan)) ? null : explode(",", $resultproduk->satuan));
        $new_st = array();
        if(!empty($satuan)){
            foreach($satuan as $op){
                $temp_st = expatAPI(URLAPI . "/v1/satuan/getsatuan_byid?id=".$op)->result->messages;
                array_push($new_st, $temp_st);
            }
        }

        $additional    = ((empty($resultproduk->additional)) ? null : explode(",", $resultproduk->additional));
        $new_ad = array();
        if(!empty($additional)){
            foreach($additional as $op){
                $temp_ad = expatAPI(URLAPI . "/v1/additional/getadditional_byid?id=".$op)->result->messages;
                array_push($new_ad, $temp_ad);
            }
        }

        $mdata = array(
            'title'         => NAMETITLE . ' - Order Detail',
            'content'       => 'widget/order/detail_order',
            'extra'		    => 'widget/order/js/_js_index',
            'product'       => $resultproduk,
            'optional'      => $new_opt,
            'satuan'        => $new_st,
            'additional'    => $new_ad,
            'totalorder'    => @count(@$cart)

        );
        $this->load->view('layout/wrapper', $mdata);
    }

    public function setcookie_add_tocart()
    {
        $input      = $this->input;
        $idcabang   = $this->security->xss_clean($input->post('idcabang'));
        $idproduk   = $this->security->xss_clean($input->post('idproduk'));
        $idoptional   = $this->security->xss_clean($input->post('idoptional'));
        $optional   = $this->security->xss_clean($input->post('optional'));
        $idsatuan     = $this->security->xss_clean($input->post('idsatuan'));
        $satuan     = $this->security->xss_clean($input->post('satuan'));
        $idadditional = $this->security->xss_clean($input->post('idadditional'));
        $additional = $this->security->xss_clean($input->post('additional'));
        $total      = $this->security->xss_clean($input->post('total_cart'));
        
        if(isset($_COOKIE['cartexpat'])){
            $cookie = stripslashes($_COOKIE['cartexpat']);
            $cart_rdy = json_decode($cookie, true);


            foreach($cart_rdy as $key => $val){
                if(
                    $val['idproduk'] == $idproduk && $val['idoptional'] == $idoptional && 
                    $val['idsatuan'] == $idsatuan && $val['idadditional'] == $idadditional 
                ){
                    $total += $val['jumlah'];
                    
                    $mdata = array(
                        "idproduk"          => $idproduk,
                        "idoptional"        => $val['idoptional'],
                        "price_optional"    => $val['price_optional'],
                        "idsatuan"          => $val['idsatuan'],
                        "price_satuan"      => $val['satuan'],
                        "idadditional"      => $val['idadditional'],
                        "price_additional"  => $val['additional'],
                        "jumlah"            => $total
                    );

                    unset($cart_rdy[$key]);
                    array_push($cart_rdy, $mdata);
                    
                    $newarr = array_values($cart_rdy);
                    $data = json_encode($newarr);
                    setcookie('cartexpat', "", time() - 3600, "/");
                    setcookie('cartexpat', $data, 2147483647, "/");
                    redirect('widget/order/detail?cabang='.$idcabang.'&product='.$idproduk);
                }
            }

            // Tambahkan produk dan optional, satuan dan additional baru
            $mdata = array(
                "idproduk"          => $idproduk,
                "idoptional"        => (empty($idoptional) ? null : $idoptional),
                "price_optional"    => (empty($optional) ? null : $optional),
                "idsatuan"          => (empty($idsatuan) ? null : $idsatuan),
                "price_satuan"      => (empty($satuan) ? null : $satuan),
                "idadditional"      => (empty($idadditional) ? null : $idadditional),
                "price_additional"  => (empty($additional) ? null : $additional),
                "jumlah"            => $total
            );         

            array_push($cart_rdy, $mdata);
            $data = json_encode($cart_rdy);
            setcookie('cartexpat', "", time() - 3600, "/");
            setcookie('cartexpat', $data, 2147483647, "/");
            redirect('widget/order/detail?cabang='.$idcabang.'&product='.$idproduk);


        } else {

            $cart_empty = array();
            $mdata = array(
                "idproduk"          => $idproduk,
                "idoptional"        => (empty($idoptional) ? null : $idoptional),
                "price_optional"    => (empty($optional) ? null : $optional),
                "idsatuan"          => (empty($idsatuan) ? null : $idsatuan),
                "price_satuan"      => (empty($satuan) ? null : $satuan),
                "idadditional"      => (empty($idadditional) ? null : $idadditional),
                "price_additional"  => (empty($additional) ? null : $additional),
                "jumlah"            => $total
            );

            array_push($cart_empty, $mdata);
            $data = json_encode($cart_empty);
            setcookie('cartexpat', "", time() - 3600, "/");
            setcookie('cartexpat', $data, 2147483647, "/");
            redirect('widget/order/detail?cabang='.$idcabang.'&product='.$idproduk);
        }

    }
    
    // public function get_harga_produk()
    // {
    //     $input = $this->input;
	// 	$id_optional = $this->security->xss_clean($input->post('id_optional'));
	// 	$id_satuan = $this->security->xss_clean($input->post('id_satuan'));
	// 	$id_additional = $this->security->xss_clean($input->post('id_additional'));

    //     // Assign variabel ke dalam array
    //     $mdata = array(
    //         'id_optional'   => $id_optional,
    //         'id_satuan'     => $id_satuan,
    //         'id_additional' => $id_additional
    //     );

    //     // Get variant by id produk
    //     $url = URLAPI . "/v1/produk/get_varianbyid?id=".$_GET['product'];
	// 	$result = expatAPI($url)->result->messages;
        

    //     // Cek apakah produk dan variant sesuai dengan dipilih user
    //     $harga;
    //     foreach($result as $dt){        
    //         if($_GET['cabang'] == $dt->id_cabang){
    //             if(
    //                 $mdata['id_optional'] == $dt->id_optional && 
    //                 $mdata['id_satuan'] == $dt->id_satuan && 
    //                 $mdata['id_additional'] == $dt->id_additional
    //             ){
    //                 $datas = array(
    //                     "id_variant"    => $dt->id,
    //                     "harga"         => @$dt->harga
    //                 );     
    //             }
    //         }
    //     }

    //     echo json_encode(@$datas);
    // }

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
        $lat            = $this->security->xss_clean($input->post('lat'));
        $long           = $this->security->xss_clean($input->post('long'));

        $this->form_validation->set_rules('nameaddress', 'Name Address', 'trim|required');
        $this->form_validation->set_rules('address', 'Address', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone Number', 'trim|required');
        $this->form_validation->set_rules('lat', 'Select Location', 'trim|required');
        $this->form_validation->set_rules('long', 'Select Location', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', $this->message->error_msg(validation_errors()));
            redirect('widget/order/addaddress/'.$token.'?idcabang='.$idcabang);
			return;
		}


        $mdata = array(
            'title'         => $nameaddress,
            'alamat'        => $address,
            'phone'         => $phone,
            'latitude'      => $lat,
            'longitude'     => $long,
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
        $lat            = $this->security->xss_clean($input->post('lat'));
        $long           = $this->security->xss_clean($input->post('long'));

        $this->form_validation->set_rules('nameaddress', 'Name Address', 'trim|required');
        $this->form_validation->set_rules('address', 'Address', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone Number', 'trim|required');
        $this->form_validation->set_rules('lat', 'Select Location', 'trim|required');
        $this->form_validation->set_rules('long', 'Select Location', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', $this->message->error_msg(validation_errors()));
            redirect('widget/order/editaddress/'.$token.'?idcabang='.$idcabang);
			return;
		}

        $mdata = array(
            'title'         => $nameaddress,
            'alamat'        => $address,
            'phone'         => $phone,
            'latitude'      => $lat,
            'longitude'     => $long,
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

    public function enterpin()
    {
        // Get Data from user
        $input          = $this->input;
		$idcabang       = $this->security->xss_clean($input->post('id_cabang'));
		$idpengiriman   = $this->security->xss_clean($input->post('idpengiriman'));
		$token          = $this->security->xss_clean($input->post('usertoken'));
		$note           = $this->security->xss_clean($input->post('inptnote'));
        $method		    = "expatbalance";
        $amount         = $this->security->xss_clean($input->post('amount'));
        $saldo          = $this->security->xss_clean($input->post('saldo'));
        
        $idproduk     = $this->security->xss_clean($input->post('idproduk'));
        $idoptional     = $this->security->xss_clean($input->post('idoptional'));
        $idadditional   = $this->security->xss_clean($input->post('idadditional'));
        $idsatuan       = $this->security->xss_clean($input->post('idsatuan'));
		$jumlah         = $this->security->xss_clean($input->post('jumlah'));

        // echo '<pre>'.print_r($idproduk,true).'</pre>';
        // echo '<pre>'.print_r($idoptional,true).'</pre>';
        // echo '<pre>'.print_r($idsatuan,true).'</pre>';
        // echo '<pre>'.print_r($idadditional,true).'</pre>';
        // echo '<pre>'.print_r($jumlah,true).'</pre>';

        // Get Alamat user
        $urlAddress 		= URLAPI . "/v1/mobile/order/last_address";
		$responseAddress 	= mobileAPI($urlAddress, $mdata = NULL, $token);
        $resultAddress      = $responseAddress->result->messages;


        // Get Cabang
        $urlCabang 		= URLAPI . "/v1/mobile/outlet/getcabang_byid?id=".$idcabang;
		$responseCabang 	= expatAPI($urlCabang);
        $resultCabang      = $responseCabang->result->messages;


        $origin = $resultAddress->address->latitude.','.$resultAddress->address->longitude;  // Latitude and longitude for origin
        $destination = $resultCabang->latitude.','.$resultCabang->longitude;  // Latitude and longitude for destination

        
        $route = $this->getFastestRoute($origin, $destination);
        
        
        // Mengecek route valid atau tidak dengan jarak maxroute
        if ($route) {
            $legs = $route['legs'][0];
            $distance = $legs['distance'];
            $jarak = str_replace(' km', '', $distance['text']);  // Remove " km" from the distance text
            if ($jarak>$resultCabang->max){
                $error = "Delivery Address is too far, max is ".$resultCabang->max ."km";
                $this->session->set_flashdata('warning_maxarea', $error);
                redirect("widget/order/ordersummary/".$token."?cabang=".$idcabang);
            }
        } else {
            $error = "No route found";
            $this->session->set_flashdata('warning_maxarea', $error);
            redirect("widget/order/ordersummary/".$token."?cabang=".$idcabang);
        }


        // Mengubah format array biasa menjadi array assosiative 
        // Dengan grouping index yang sama disetiap array
        $originalArrays = array(
            $jumlah, 
            $idproduk, 
            $idoptional, 
            $idsatuan, 
            $idadditional
        );
        $result = array();
        $keys = array(
            "jumlah", 
            "idproduk", 
            "idoptional", 
            "idsatuan", 
            "idadditional"
        );

        for ($i = 0; $i < count($idproduk); $i++) {
            $temp = array();
            for ($j = 0; $j < count($originalArrays); $j++) {
                $temp[$keys[$j]] = $originalArrays[$j][$i];
            }
            $result[] = $temp;
        }


        // Melakukan pemecahan array dengan sesuai kategori
        $final_items = array();
        foreach($result as $key => $dt){
            $temp_produk['tipe']    = 'produk';
            $temp_produk['id']      = $dt['idproduk'];
            $temp_produk['jumlah']  = $dt['jumlah'];
            $temp_produk['group']  = $key;

            $temp_satuan['tipe']    = 'satuan';
            $temp_satuan['id']      = $dt['idsatuan'];
            $temp_satuan['jumlah']  = $dt['jumlah'];
            $temp_satuan['group']  = $key;

            array_push($final_items, ...array($temp_produk, $temp_satuan));
            
            if($dt['idoptional'] != 0){
                $temp_optional['tipe']    = 'optional';
                $temp_optional['id']      = $dt['idoptional'];
                $temp_optional['jumlah']  = $dt['jumlah'];
                $temp_optional['group']  = $key;
                array_push($final_items, $temp_optional);
            }
            
            if($dt['idadditional'] != 0){
                $temp_additional['tipe']    = 'additional';
                $temp_additional['id']      = $dt['idadditional'];
                $temp_additional['jumlah']  = $dt['jumlah'];
                $temp_additional['group']  = $key;
                array_push($final_items, $temp_additional);
            }

        }
                
        // Assign data user ke array
        $mdata = array(
            'id_pengiriman'     => (($idpengiriman != null) ? $idpengiriman : null),
            'id_cabang'         => $idcabang, 
            'is_pickup'         => (($idpengiriman != null) ? 'No' : 'Yes'),
            'note'              => ($note == null ? null : $note),
            'alamat'            => (($idpengiriman != null) ? $resultAddress->address->alamat : null),
            'phone'             => (($idpengiriman != null) ? $resultAddress->address->phone : null),
            'carabayar'         => $method,
            'items'             => $final_items
        );

        
        // Set Session Ordersummary
        $this->session->set_userdata('ordersummary', $mdata);


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
        setcookie('cartexpat', "", time() - 3600, "/");
        $this->session->sess_destroy();
    }

    public function notif($token = NULL)
    {
        // Remove cookie dan session
        setcookie('cartexpat', "", time() - 3600, "/");
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

    public function list_promotion($token)
    {
        $mdata = array(
            'title'         => NAMETITLE . ' - List Promotion',
            'content'       => 'widget/promotion/list_promotion',
            'extra'		    => 'widget/promotion/js/_js_promotion',
            'token'         => $token,
        );
        $this->load->view('layout/wrapper', $mdata);
    }

    public function claim_promotion($token)
    {
        $mdata = array(
            'title'         => NAMETITLE . ' - Claim Promotion',
            'content'       => 'widget/promotion/claim_promotion',
            'extra'		    => 'widget/promotion/js/_js_promotion',
            'token'         => $token,
        );
        $this->load->view('layout/wrapper', $mdata);
    }


}