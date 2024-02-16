<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Topup extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{	

		$mdata = array(
			'title'     => NAMETITLE . ' - Topup',
			'content'   => 'widget/topup/index',
			'extra'		=> 'widget/topup/js/_js_index',
		);
		$this->load->view('layout/wrapper', $mdata);
	}


}
