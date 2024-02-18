<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Topup extends CI_Controller
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
            'title'             => NAMETITLE . ' - Topup',
            'content'           => 'admin/promotion/index',
            'extra'             => 'admin/promotion/js/_js_index',
            'master_active'     => 'active',
            'master_in'         => 'in',
            'dropdown_promotion' => 'text-expat-green'
        );
        $this->load->view('layout/wrapper', $data);

    }

    public function history()
    {
        $data = array(
            'title'             => NAMETITLE . ' - History Topup',
            'content'           => 'admin/topup/history',
            'extra'             => 'admin/topup/js/_js_index',
            'historytopup_active'     => 'active',
        );
        $this->load->view('layout/wrapper', $data);
    }
}