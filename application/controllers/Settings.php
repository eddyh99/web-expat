<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Settings extends CI_Controller
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
            'title'             => NAMETITLE . ' - Settings',
            'content'           => 'admin/settings/index',
            'extra'             => 'admin/settings/js/_js_index',
            'settings_active'     => 'active',
        );

        $this->load->view('layout/wrapper', $data);

    }
}