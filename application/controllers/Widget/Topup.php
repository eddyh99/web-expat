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
		//"69712d282337451ae8650f8e575319c26ed59669";
		$url 		= URLAPI . "/v1/member/get_bytoken?token=".$token;
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
		
		$invoiceID	= date("Ymd").uniqid();
		//echo "<pre>".print_r($_POST,true)."</pre>";
		if ($method=="credit"){
			$bodyreq = array (
						'order' => array (
							'amount' 		 => $amount+($amount*0.03),
							'invoice_number' => $invoiceID,
							'currency' 		 => 'IDR',
							'callback_url' 	 => base_url()."widget/topup/success",
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
							'callback_url' 	 => base_url()."widget/topup/success",
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
							'callback_url' 	 => base_url()."widget/topup/success",
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
							'callback_url' 	 => base_url()."widget/topup/notify",
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
	
	public function notify(){
		$notif =  json_decode(file_get_contents('php://input'), true);	
		$inv	= $notif["order"]["invoice_number"];
		$email	= $notif["customer"]["email"];
		if ($notif["transaction"]["status"]=="SUCCESS"){
			$url 	= URLAPI . "/payment/topup_status";
			$mdata	= array(
				"invoice"	=> $inv,
				"email"		=> $email
			);
			$response = expatAPI($url,json_encode($mdata))->result->messages; 
			print_r($response);
			die;
			$this->doku_log(json_encode($response));
			redirect(base_url()."widget/topup/success");
		}
	}
	
	function doku_log($log_msg, $invoice_number = '')
	{
		$log_filename = "doku_log";
		$log_header = date(DATE_ATOM, time()) . ' ' . 'Notif ' . '---> ' . $invoice_number . " : ";
		if (!file_exists($log_filename)) {
			// create directory/folder uploads.
			mkdir($log_filename, 0777, true);
		}
		$log_file_data = $log_filename . '/log_' . date('d-M-Y') . '.log';
		// if you don't add `FILE_APPEND`, the file will be erased each time you add a log
		file_put_contents($log_file_data, $log_header . $log_msg . "\n", FILE_APPEND);
	}
	
	public function success(){
		echo "Sukses";
	}
	
	public function cancel(){
		$this->session->set_flashdata("error","Your topup cannot be processed");
		redirect(base_url()."widget/topup/membertopup/".$token);
	}
}
