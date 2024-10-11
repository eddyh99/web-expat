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
            'promotion_active'  => 'active',
        );
        $this->load->view('layout/wrapper', $data);

    }

    public function list_allpromotion()
    {
        $status     = $this->security->xss_clean($this->input->post('status'));

        if($status == 'all'){
            $url = URLAPI . "/v1/mobile/promotion/get_allpromo";    
        }else if($status == 'instore'){
            $url = URLAPI . "/v1/mobile/promotion/get_allinstore";      
        }else if($status == 'online'){
            $url = URLAPI . "/v1/mobile/promotion/get_allonline";           
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
            'promotion_active'  => 'active',
        );
        $this->load->view('layout/wrapper', $data);
    }

    public function addpromotion_process()
    {
		$this->form_validation->set_rules('description', 'Description', 'trim|required');
		$this->form_validation->set_rules('promotion_type', 'Promotion Type', 'trim|required');
		$this->form_validation->set_rules('start_date', 'Start Date', 'trim|required');
		$this->form_validation->set_rules('end_date', 'End Date', 'trim|required');
		$this->form_validation->set_rules('milestone', 'Milestone', 'trim|required|greater_than_equal_to[0]');
		$this->form_validation->set_rules('minimum', 'Minimum Purchase', 'trim|required|greater_than[0]');
		$this->form_validation->set_rules('discount_type', 'Discount Type', 'trim|required');


        if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error_validation', $this->message->error_msg(validation_errors()));
			redirect("promotion/add_promotion");
			return;
		}

        $input              = $this->input;
        $description        = $this->security->xss_clean($this->input->post("description"));
        $promotion_type     = $this->security->xss_clean($this->input->post("promotion_type"));
        $start_date         = $this->security->xss_clean($this->input->post("start_date"));
        $end_date           = $this->security->xss_clean($this->input->post("end_date"));
        $milestone          = $this->security->xss_clean($this->input->post("milestone"));
        $minimum            = $this->security->xss_clean($this->input->post("minimum"));
        $discount_type      = $this->security->xss_clean($this->input->post("discount_type"));
        $disc_amount        = $this->security->xss_clean($this->input->post("disc_amount"));

        $image      = $this->security->xss_clean(@$_FILES['imgpromotion']);

        if(!empty($image['name'])){

            // Maximum 2MB in bytes 
            $maxSize = 2 * 1024 * 1024; 
    
            // Allowed MIME types for images
            $allowedTypes = array('image/jpeg', 'image/png', 'image/jpg');

            if ($image['size'] > $maxSize) {
                $this->session->set_flashdata('error', 'Your image is too big, Maximum 2MB');
                redirect("promotion/add_promotion");
                return;
            } else if (!in_array($image['type'], $allowedTypes)){
                $this->session->set_flashdata('error', 'Error: Invalid file type. Only JPEG, JPG, and PNG are allowed.');
                redirect("promotion/add_promotion");
                return;
            }
 

            $blob       = curl_file_create($image['tmp_name'],$image['type']);
            $mdata = array(
                "deskripsi"   => $description,
                "tipe"        => $promotion_type,
                "start_date"  => $start_date,
                "end_date"    => $end_date,
                "image"       => $blob,
                'milestone'   => $milestone,
                'minimum'     => $minimum,
                'discount_type' => $discount_type,
                'disc_amount'   => $disc_amount,
            );
        }else{

            $mdata = array(
                "deskripsi"   => $description,
                "tipe"        => $promotion_type,
                "start_date"  => $start_date,
                "end_date"    => $end_date,
                'milestone'   => $milestone,
                'minimum'     => $minimum,
                'discount_type' => $discount_type,
                'disc_amount'   => $disc_amount,
            );

        }

        $url = URLAPI . "/v1/promotion/addPromo";
		$response = expatAPI($url, json_encode($mdata));
        $result = $response->result;
        

        if($response->status == 200) {
            $this->session->set_flashdata('success', $result->messages);
			redirect('promotion');
			return;
        }else{
            $this->session->set_flashdata('error', $result->messages->error);
			redirect('promotion/add_promotion');
			return;
        }
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
            'promotion'         => $result,
            'promotion_active'   => 'active',
        );

        $this->load->view('layout/wrapper', $data);
    }

    public function editpromotion_process()
    {
		$this->form_validation->set_rules('description', 'Description', 'trim|required');
		$this->form_validation->set_rules('promotion_type', 'Promotion Type', 'trim|required');
		$this->form_validation->set_rules('start_date', 'Start Date', 'trim|required');
		$this->form_validation->set_rules('end_date', 'End Date', 'trim|required');
		$this->form_validation->set_rules('milestone', 'Milestone', 'trim|required|greater_than_equal_to[0]');
		$this->form_validation->set_rules('minimum', 'Minimum Purchase', 'trim|required|greater_than[0]');
		$this->form_validation->set_rules('discount_type', 'Discount Type', 'trim|required');

        $input      = $this->input;
        $urisegment   = $this->security->xss_clean($input->post('urisegment'));

        if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error_validation', $this->message->error_msg(validation_errors()));
            redirect('promotion/edit_promotion/'.$urisegment);
			return;
		}

        $id                 = base64_decode($urisegment);
        $description        = $this->security->xss_clean($this->input->post("description"));
        $promotion_type     = $this->security->xss_clean($this->input->post("promotion_type"));
        
        $start_date         = $this->security->xss_clean($this->input->post("start_date"));
        $new_start_date    = date("Y-m-d", strtotime($start_date)); 
        
        $end_date           = $this->security->xss_clean($this->input->post("end_date"));
        $new_end_date       = date("Y-m-d", strtotime($end_date)); 

        $milestone          = $this->security->xss_clean($this->input->post("milestone"));
        $minimum            = $this->security->xss_clean($this->input->post("minimum"));
        $discount_type      = $this->security->xss_clean($this->input->post("discount_type"));
        $disc_amount        = $this->security->xss_clean($this->input->post("disc_amount"));


        $image      = $this->security->xss_clean(@$_FILES['imgpromotion']);
        if(!empty($image['name'])){

            // Maximum 2MB in bytes 
            $maxSize = 2 * 1024 * 1024; 

            // Allowed MIME types for images
            $allowedTypes = array('image/jpeg', 'image/png', 'image/jpg');

            if ($image['size'] > $maxSize) {
                $this->session->set_flashdata('error', 'Your image is too big, Maximum 2MB');
                redirect("promotion/add_promotion");
                return;
            } else if (!in_array($image['type'], $allowedTypes)){
                $this->session->set_flashdata('error', 'Error: Invalid file type. Only JPEG, JPG, and PNG are allowed.');
                redirect("promotion/add_promotion");
                return;
            }

            $blob       = curl_file_create($image['tmp_name'],$image['type']);
            $mdata = array(
                "deskripsi"   => $description,
                "tipe"        => $promotion_type,
                "start_date"  => $new_start_date,
                "end_date"    => $new_end_date,
                "image"       => $blob,
                'milestone'   => $milestone,
                'minimum'     => $minimum,
                'discount_type' => $discount_type,
                'disc_amount'   => $disc_amount,
            );
        }else{

            $mdata = array(
                "deskripsi"   => $description,
                "tipe"        => $promotion_type,
                "start_date"  => $new_start_date,
                "end_date"    => $new_end_date,
                'milestone'   => $milestone,
                'minimum'     => $minimum,
                'discount_type' => $discount_type,
                'disc_amount'   => $disc_amount,
            );

        }
        
        // echo '<pre>'.print_r($mdata,true).'</pre>';
        // die;
        
        $url = URLAPI . "/v1/promotion/updatePromo?id=".$id;
		$response = expatAPI($url, json_encode($mdata));
        $result = $response->result;
        // echo '<pre>'.print_r($result,true).'</pre>';
        // die;

        
        if($response->status == 200){
            $this->session->set_flashdata('success', $result->messages);
			redirect('promotion');
			return;
        }else{
            $this->session->set_flashdata('error', $result->messages->error);
            redirect('promotion/edit_promotion/'.$urisegment);
            return;
        }
    }


    public function delete($id)
    {
        $id_member = base64_decode($this->security->xss_clean($id));

        $url = URLAPI . "/v1/promotion/deletePromo?id=".$id_member;
		$response = expatAPI($url);
        $result = $response->result;
 

        if($response->status == 200){
            $this->session->set_flashdata('success', $result->messages);
			redirect('promotion');
			return;
        }else{
            $this->session->set_flashdata('error', $result->messages->error);
            redirect('promotion');
            return;
        }
    }

}