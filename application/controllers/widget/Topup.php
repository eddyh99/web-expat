<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Topup extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function membertopup($token)
	{	
		//LISTIE "69712d282337451ae8650f8e575319c26ed59669";
		//Killua "bbe287cf3a3bf23306bb175c8461ce86a16f6a75";
		// $url 		= URLAPI . "/v1/member/get_bytoken?token=8bb791cab9ffc8518f808425cbbec28d9947206e";
		$url 		= URLAPI . "/auth/logintoken?token=".$token;
		$response 	= expatAPI($url);


		if($response->status == 200) {		
			$mdata = array(
				'title'     => NAMETITLE . ' - Topup',
				'content'   => 'widget/topup/index',
				'extra'		=> 'widget/topup/js/_js_index',
				'token'		=> $token,
				'email'		=> $response->result->messages->email
			);
			$this->load->view('layout/wrapper', $mdata);
		}else{
			echo "un authorized access, please relogin again";
		}
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

	public function confirm(){
		$input		= $this->input;
		$token      = $this->security->xss_clean($input->post('token'));
		$email      = $this->security->xss_clean($input->post('email'));
        $amount     = str_replace(",","",$this->security->xss_clean($input->post('amount')));
		$method		= $this->security->xss_clean($input->post('methodpayment'));
		
		if ($amount>2000000){
		    echo "The maximum allowed top-up is IDR 2,000,000.";
		}
		
		$url 		= URLAPI . "/v1/mobile/member/get_userdetail";
		$response 	= mobileAPI($url,null,$token);
		if ($response->status==200){
		    $saldo=$response->result->messages->saldo;
		    if ($amount>(2000000-$saldo)){
		        echo "Your remaining top-up balance is ".number_format(2000000-$saldo).". The maximum allowed balance is IDR 2,000,000";
		    }
		}

		$invoiceID	= date("Ymd").uniqid();
		// echo "<pre>".print_r($_POST,true)."</pre>";
		if ($method=="credit"){
			$bodyreq = array (
						'order' => array (
							'amount' 		 => $amount+($amount*0.03),
							'invoice_number' => $invoiceID,
							'currency' 		 => 'IDR',
							'callback_url' 	 => base_url()."widget/topup/success/".$token."/".$invoiceID,
							"callback_url_cancel"	=> base_url()."widget/topup/cancel",
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
							'callback_url' 	 => base_url()."widget/topup/success/".$token."/".$invoiceID,
							"callback_url_cancel"	=> base_url()."widget/topup/cancel",
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
							'callback_url' 	 => base_url()."widget/topup/success/".$token."/".$invoiceID,
							"callback_url_cancel"	=> base_url()."widget/topup/cancel",
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
							'callback_url' 	 => base_url()."widget/topup/success/".$token."/".$invoiceID,
							"callback_url_cancel"	=> base_url()."widget/topup/cancel",
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
		
		$mdata	= array(
			"token"		=> $token,
			"invoice"	=> $invoiceID,
			"amount"	=> $amount
		);
		
		$url 		= URLAPI . "/payment/create_topup";
		$response 	= expatAPI($url,json_encode($mdata));
		
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
		//echo "<pre>".print_r($result,true)."</pre>";
		//die;
		if ($result->message[0]=="SUCCESS"){
			redirect($result->response->payment->url);
		}else{
			$this->session->set_flashdata("error","Your topup cannot be processed");
			redirect(base_url()."widget/topup/membertopup/".$token);
		}
	}
	
	public function summary($token)
	{

		$amount     = str_replace(",","",$this->security->xss_clean($this->input->post('amount')));
        $_POST["amount"]=$amount;


		$this->form_validation->set_rules('token', 'Token', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('amount', 'Amount', 'trim|required|greater_than[0]|less_than_equal_to[1000000]');
		$this->form_validation->set_rules('methodpayment', 'Method', 'trim|required');
		
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', $this->message->error_msg(validation_errors()));
			redirect("widget/topup/membertopup/".$token);
			return;
		}


		$input		= $this->input;
		$token      = $this->security->xss_clean($input->post('token'));
		$email      = $this->security->xss_clean($input->post('email'));
        $amount     = $this->security->xss_clean($input->post('amount'));
        $method		= $this->security->xss_clean($input->post('methodpayment'));

		$mdata = array(
			"token"		=> $token,
			"email"		=> $email,
			"amount"	=> $amount,
			"method"	=> $method
		);

		$mdata = array(
            'title'     => NAMETITLE . ' - Topup Success',
            'content'   => 'widget/topup/topup_summary',
			'data'		=> $mdata,
            'extra'		=> 'widget/topup/js/_js_index',
        );
        $this->load->view('layout/wrapper', $mdata);
	}
	
	public function success($token = NULL, $invoice = NULL)
	{

		$urlPoin 		= URLAPI . "/payment/checkpoin?invoice=".$invoice."&tipe=topup";
		$responsePoin 	= mobileAPI($urlPoin, $mdata = NULL, $token);
        $resultPoin      = $responsePoin->result->messages;

		$mdata = array(
            'title'     => NAMETITLE . ' - Topup Success',
            'content'   => 'widget/topup/topup_success',
			'invoice'	=> $resultPoin
        );
        $this->load->view('layout/wrapper', $mdata);
	}
	
	public function cancel()
	{
		$this->session->set_flashdata("error","Your topup cannot be processed");
		redirect(base_url()."widget/topup/membertopup/".$token);
	}
}
