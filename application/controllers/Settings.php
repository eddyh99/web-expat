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
        
        $url = URLAPI . "/v1/settings/get_setting";    
        $response = expatAPI($url)->result->messages;

        $data = array(
            'title'             => NAMETITLE . ' - Settings',
            'content'           => 'admin/settings/index',
            'config'            => $response,
            'extra'             => 'admin/settings/js/_js_index',
            'settings_active'     => 'active',
        );

        $this->load->view('layout/wrapper', $data);

    }
    
    public function update_settings()
    {
        $this->form_validation->set_rules('poin', 'Base Poin', 'trim|required');
		$this->form_validation->set_rules('dfee', 'Delivery Fee', 'trim|required');
		$this->form_validation->set_rules('maxarea', 'Max Area', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error_validation', $this->message->error_msg(validation_errors()));
			redirect("employe/add_employe");
			return;
		}

        $input      = $this->input;
        $poin       = $this->security->xss_clean($input->post('poin'));
        $dfee       = $this->security->xss_clean($input->post('dfee'));
        $maxarea    = $this->security->xss_clean($input->post('maxarea'));
        
        $mdata = array(
            "basepoin"      => $poin,
            "deliveryfee"   => $dfee,
            "maxarea"       => $maxarea,
        );

        $url = URLAPI . "/v1/settings/updateSetting";    
        $response = expatAPI($url,json_encode($mdata));
        $result = $response->result;

  
        if($response->status == 200){
            $this->session->set_flashdata('success', $result->messages);
			redirect('settings');
			return;
        }else{
            $this->session->set_flashdata('error', $result->messages->error);
            redirect('settings');
            return;
        }
    }
}