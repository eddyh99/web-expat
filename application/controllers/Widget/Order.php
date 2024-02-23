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
        $mdata = array(
            'title'     => NAMETITLE . ' - Order',
            'content'   => 'widget/order/order',
            'extra'		=> 'widget/order/js/_js_index',
        );
        $this->load->view('layout/wrapper', $mdata);
	}

    public function detail()
    {
        $mdata = array(
            'title'     => NAMETITLE . ' - Order Detail',
            'content'   => 'widget/order/detail_order',
            'extra'		=> 'widget/order/js/_js_index',
        );
        $this->load->view('layout/wrapper', $mdata);
    }

    public function detail_process()
    {
        $input = $this->input;
		$typecoffe = $this->security->xss_clean($input->post('typecoffe'));
		$cupsize = $this->security->xss_clean($input->post('cupsize'));
		$shot = $this->security->xss_clean($input->post('shot'));
		$injumlahcoffe = $this->security->xss_clean($input->post('injumlahcoffe'));

        $mdata = array(
            'typecoffe'     => $typecoffe,
            'cupsize'       => $cupsize,
            'shot'          => $shot,
            'jumlahcoffe'   => $injumlahcoffe
        );  

        echo '<pre>'.print_r($mdata,true).'</pre>';
        die;
    }
	
}