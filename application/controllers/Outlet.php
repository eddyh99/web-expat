<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Outlet extends CI_Controller
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
            'title'             => NAMETITLE . ' - Outlet',
            'content'           => 'admin/outlet/index',
            'extra'             => 'admin/outlet/js/_js_index',
            'master_active'     => 'active',
            'master_in'         => 'in',
            'dropdown_outlet'   => 'text-expat-green'
        );
        $this->load->view('layout/wrapper', $data);

    }

    public function list_alloutlet()
    {
		$url = URLAPI . "/v1/outlet/get_allcabang";
		$result = expatAPI($url)->result->messages;
        echo json_encode($result);  
        die;      

    }

    public function add_outlet()
    {
        $data = array(
            'title'         => NAMETITLE . ' - Add Outlet',
            'content'       => 'admin/outlet/add_outlet',
            'extra'         => 'admin/outlet/js/_js_index',
            'master_active'     => 'active',
            'master_in'         => 'in',
            'dropdown_outlet'   => 'text-expat-green'
        );
        $this->load->view('layout/wrapper', $data);
    }

    public function addoutlet_process()
    {
		$this->form_validation->set_rules('name', 'Name Outlet', 'trim|required');
		$this->form_validation->set_rules('address', 'Address Outlet', 'trim|required');
		$this->form_validation->set_rules('opening', 'Opening', 'trim|required');
		$this->form_validation->set_rules('contact', 'Contact', 'trim|required');
		$this->form_validation->set_rules('provinsi', 'Province', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error_validation', $this->message->error_msg(validation_errors()));
			redirect("outlet/add_outlet");
			return;
		}

        $input      = $this->input;
        $name       = $this->security->xss_clean($this->input->post("name"));
        $address    = $this->security->xss_clean($this->input->post("address"));
        $opening    = $this->security->xss_clean($this->input->post("opening"));
        $contact    = $this->security->xss_clean($this->input->post("contact"));
        $provinsi    = $this->security->xss_clean($this->input->post("provinsi"));

        $image      = $this->security->xss_clean($_FILES['imgoutlet']);
        if(!empty($image['name'])){
            $blob       = curl_file_create($image['tmp_name'],$image['type']);
            $mdata = array(
                "nama"        => $name,
                "alamat"      => $address,
                "opening"     => $opening,
                "kontak"      => $contact,
                "provinsi"    => $provinsi,
                "image"       => $blob
            );
        }else{
            $mdata = array(
                "nama"        => $name,
                "alamat"      => $address,
                "opening"     => $opening,
                "kontak"      => $contact,
                "provinsi"    => $provinsi,
            );

        }

        $url = URLAPI . "/v1/outlet/addCabang";
		$response = expatAPI($url, json_encode($mdata));
        $result = $response->result;


        if($response->status == 200) {
            $this->session->set_flashdata('success', $result->messages);
			redirect('outlet');
			return;
        }else{
            $this->session->set_flashdata('error', $result->messages->error);
			redirect('outlet/add_outlet');
			return;
        }
    }

    public function edit_outlet($id)
    {
        $id_outlet	= base64_decode($this->security->xss_clean($id));

        $url = URLAPI . "/v1/outlet/getcabang_byid?id=".$id_outlet;
		$result = expatAPI($url)->result->messages;

        // echo '<pre>'.print_r($result,true).'</pre>';
        // die;
        $data = array(
            'title'             => NAMETITLE . ' - Edit Outlet',
            'content'           => 'admin/outlet/edit_outlet',
            'extra'             => 'admin/outlet/js/_js_index',
            'outlet'              => $result,
            'master_active'     => 'active',
            'master_in'         => 'in',
            'dropdown_outlet'   => 'text-expat-green'
        );

        $this->load->view('layout/wrapper', $data);
    }

    public function editoutlet_process()
    {
        $this->form_validation->set_rules('name', 'Outlet Name', 'trim|required');
		$this->form_validation->set_rules('address', 'Address', 'trim|required');
		$this->form_validation->set_rules('opening', 'opening', 'trim|required');
		$this->form_validation->set_rules('contact', 'contact', 'trim|required');
		$this->form_validation->set_rules('provinsi', 'Province', 'trim|required');

        $input      = $this->input;
        $urisegment   = $this->security->xss_clean($input->post('urisegment'));

        if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error_validation', $this->message->error_msg(validation_errors()));
            redirect('outlet/edit_outlet/'.$urisegment);
			return;
		}

        $id             = base64_decode($urisegment);
        $name           = $this->security->xss_clean($input->post('name'));
        $address       = $this->security->xss_clean($input->post('address'));
        $opening       = $this->security->xss_clean($input->post('opening'));
        $contact       = $this->security->xss_clean($input->post('contact'));
        $provinsi      = $this->security->xss_clean($this->input->post("provinsi"));

        
        $image      = $this->security->xss_clean(@$_FILES['imgoutlet']);
        if(!empty($image['name'])){
            $blob       = curl_file_create($image['tmp_name'],$image['type']);
            $mdata = array(
                "nama"        => $name,
                "alamat"      => $address,
                "opening"     => $opening,
                "kontak"      => $contact,
                "provinsi"    => $provinsi,
                "image"       => $blob
            );
        }else{

            $mdata = array(
                "nama"        => $name,
                "alamat"      => $address,
                "opening"     => $opening,
                "kontak"      => $contact,
                "provinsi"    => $provinsi,
            );

        }


        $url = URLAPI . "/v1/outlet/updateCabang?id=".$id;
		$response = expatAPI($url, json_encode($mdata));
        $result = $response->result;

        if($response->status == 200){
            $this->session->set_flashdata('success', $result->messages);
			redirect('outlet');
			return;
        }else{
            $this->session->set_flashdata('error', $result->messages->error);
            redirect('outlet/edit_outlet/'.$urisegment);
            return;
        }
    }

    public function delete($id)
    {
        $id_member = base64_decode($this->security->xss_clean($id));

        $url = URLAPI . "/v1/outlet/deleteCabang?id=".$id_member;
		$response = expatAPI($url);
        $result = $response->result;
 

        if($response->status == 200){
            $this->session->set_flashdata('success', $result->messages);
			redirect('outlet');
			return;
        }else{
            $this->session->set_flashdata('error', $result->messages->error);
            redirect('outlet');
            return;
        }
    }


}