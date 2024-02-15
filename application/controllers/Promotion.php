<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Promotion extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!isset($this->session->userdata['logged_user'])) {
			redirect('/');
		}

    }

    public function index()
    {
        $data = array(
            'title'             => NAMETITLE . ' - Promotion',
            'content'           => 'admin/promotion/index',
            'extra'             => 'admin/promotion/js/_js_index',
            'promotion_active'     => 'active',
        );
        $this->load->view('layout/wrapper-dashboard', $data);

    }

    public function list_allpromotion()
    {
        $status     = $this->security->xss_clean($this->input->post('status'));

        if($status == 'all'){
            $url = URLAPI . "/v1/promotion/get_allpromo";    
        }else if($status == 'instore'){
            $url = URLAPI . "/v1/promotion/get_allinstore";      
        }else if($status == 'online'){
            $url = URLAPI . "/v1/promotion/get_allonline";           
        }

		$response = expatAPI($url)->result->messages;
        echo json_encode($response);        
    }

    public function add_promotion()
    {
        $data = array(
            'title'         => NAMETITLE . ' - Add Promotion',
            'content'       => 'admin/promotion/add_promotion',
            'extra'         => 'admin/promotion/js/_js_index',
            'promotion_active' => 'active',
        );
        $this->load->view('layout/wrapper-dashboard', $data);
    }
    public function edit_promotion($id)
    {
        $id_promotion	= base64_decode($this->security->xss_clean($id));

        $url = URLAPI . "/v1/promotion/getpromo_byid?id=".$id_promotion;
		$result = expatAPI($url)->result->messages;


        $data = array(
            'title'             => NAMETITLE . ' - Edit Member',
            'content'           => 'admin/promotion/edit_promotion',
            'extra'             => 'admin/promotion/js/_js_index',
            'promotion_active'       => 'active',
            'promotion'              => $result,
        );

        $this->load->view('layout/wrapper-dashboard', $data);
    }
}