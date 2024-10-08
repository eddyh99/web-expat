<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payment extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function notify(){
		$notif =  json_decode(file_get_contents('php://input'), true);
		$inv	= $notif["order"]["invoice_number"];
		if ($notif["transaction"]["status"]=="SUCCESS"){
			$url 	= URLAPI . "/payment/transaction_status";
			$mdata	= array(
				"invoice"	=> $inv,
			);
			$response = expatAPI($url,json_encode($mdata))->result->messages; 
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
}
