<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Member extends CI_Controller
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
            'title'             => NAMETITLE . ' - Member',
            'content'           => 'admin/member/index',
            'extra'             => 'admin/member/js/_js_index',
            'master_active'     => 'active',
            'master_in'         => 'in',
            'dropdown_member'  => 'text-expat-green'
        );

        $this->load->view('layout/wrapper', $data);

    }

    
    public function list_allmember()
    {
        $status     = $this->security->xss_clean($this->input->post('status'));
		$url = URLAPI . "/v1/member/get_allmember?role=member";
		$response = expatAPI($url)->result->messages;

        $resultActive = array();
        $resultNew = array();
        $resultDisabled = array();
        foreach($response as $dt){
            if($dt->status == 'active'){
                $mdata = array(
                    "id" => $dt->id,
                    "memberid" => $dt->memberid,
                    "email" => $dt->email,
                    "nama" => $dt->nama,
                    "dob" => $dt->dob,
                    "gender" => $dt->gender,
                    "status" => $dt->status,
                    "membership" => $dt->membership,
                );
                array_push($resultActive, $mdata);
            }else if($dt->status == 'new'){
                $mdata = array(
                    "id" => $dt->id,
                    "memberid" => $dt->memberid,
                    "email" => $dt->email,
                    "nama" => $dt->nama,
                    "dob" => $dt->dob,
                    "gender" => $dt->gender,
                    "status" => $dt->status,
                    "membership" => $dt->membership,
                );
                array_push($resultNew, $mdata);
            }else if($dt->status == 'disabled'){
                $mdata = array(
                    "id" => $dt->id,
                    "memberid" => $dt->memberid,
                    "email" => $dt->email,
                    "nama" => $dt->nama,
                    "dob" => $dt->dob,
                    "gender" => $dt->gender,
                    "status" => $dt->status,
                    "membership" => $dt->membership,
                );
                array_push($resultDisabled, $mdata);
            }
        }

        if($status == 'active'){
            echo json_encode($resultActive);        
        }else if($status == 'new'){
            echo json_encode($resultNew);        
        }else if($status == 'disabled'){
            echo json_encode($resultDisabled);        
        }

    }

    public function add_member()
    {
        $data = array(
            'title'             => NAMETITLE . ' - Add Member',
            'content'           => 'admin/member/add_member',
            'extra'             => 'admin/member/js/_js_index',
            'master_active'     => 'active',
            'master_in'         => 'in',
            'dropdown_member'   => 'text-expat-green'
        );
        $this->load->view('layout/wrapper', $data);
    }

    public function addmember_process()
    {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('passwd', 'Password', 'trim|required');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('gender', 'Gender', 'trim|required');
		$this->form_validation->set_rules('membership', 'Membership', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error_validation', $this->message->error_msg(validation_errors()));
			redirect("user/tambah_user");
			return;
		}

        $input      = $this->input;
        $email      = $this->security->xss_clean($input->post('email'));
        $passwd     = $this->security->xss_clean($input->post('passwd'));
        $name       = $this->security->xss_clean($input->post('name'));
        $gender     = $this->security->xss_clean($input->post('gender'));
        $membership = $this->security->xss_clean($input->post('membership'));

        $mdata = array(
            "email"         => $email,
            "passwd"        => sha1($passwd),
            "nama"          => $name,
            "gender"        => $gender,
            "role"          => 'member',
            "membership"    => $membership,
        );

        
		$url = URLAPI . "/v1/member/addMember";
		$response = expatAPI($url, json_encode($mdata));
        $result = $response->result;

        // echo '<pre>'.print_r($response,true).'</pre>';
        // die;

        if($response->status == 200) {
            $this->session->set_flashdata('success', $result->messages);
			redirect('member');
			return;
        }else{
            $this->session->set_flashdata('error', $result->messages->error);
			redirect('member/add_member');
			return;
        }
    } 

    public function edit_member($id)
    {
        $id_member	= base64_decode($this->security->xss_clean($id));

        $url = URLAPI . "/v1/member/get_byid?id=".$id_member;
		$result = expatAPI($url)->result->messages;

        $data = array(
            'title'             => NAMETITLE . ' - Edit Member',
            'content'           => 'admin/member/edit_member',
            'extra'             => 'admin/member/js/_js_index',
            'member'            => $result,
            'master_active'     => 'active',
            'master_in'         => 'in',
            'dropdown_member'   => 'text-expat-green'
        );

        $this->load->view('layout/wrapper', $data);
    }


    public function editmember_process()
    {
		$this->form_validation->set_rules('passwd', 'Password', 'trim');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('gender', 'Gender', 'trim|required');
		$this->form_validation->set_rules('membership', 'Membership', 'trim|required');

        $input      = $this->input;
        $urisegment   = $this->security->xss_clean($input->post('urisegment'));

        if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error_validation', $this->message->error_msg(validation_errors()));
            redirect('member/edit_member/'.$urisegment);
			return;
		}

        $id         = base64_decode($urisegment);
        $oldpass    = $this->security->xss_clean($input->post('oldpass'));
        $name       = $this->security->xss_clean($input->post('name'));
        $newpasswd  = $this->security->xss_clean($input->post('passwd'));
        $gender     = $this->security->xss_clean($input->post('gender'));
        $membership = $this->security->xss_clean($input->post('membership'));

        

        if (empty($newpasswd)){
            $mdata = array(
                "passwd"        => $oldpass,
                "nama"          => $name,
                "gender"        => $gender,
                "membership"    => $membership,
                "role"          => 'member'
            );
        }else{
            $mdata = array(
                "passwd"        => sha1($newpasswd),
                "nama"          => $name,
                "gender"        => $gender,
                "membership"    => $membership,
                "role"          => 'member'
            );
        
        }
        $url = URLAPI . "/v1/member/updateMember?id=".$id;
		$response = expatAPI($url, json_encode($mdata));
        $result = $response->result;


        if($response->status == 200){
            $this->session->set_flashdata('success', $result->messages);
			redirect('member');
			return;
        }else{
            $this->session->set_flashdata('error', $result->messages->error);
            redirect('member/edit_member/'.$urisegment);
            return;
        }
    }


    public function delete($id)
    {
        $id_member = base64_decode($this->security->xss_clean($id));

        $url = URLAPI . "/v1/member/deleteMember?id=".$id_member;
		$response = expatAPI($url);
        $result = $response->result;
 

        if($response->status == 200){
            $this->session->set_flashdata('success', $result->messages);
			redirect('member');
			return;
        }else{
            $this->session->set_flashdata('error', $result->messages->error);
            redirect('member');
            return;
        }
    }


    public function manual_activation($id)
    {
        $id_member = base64_decode($this->security->xss_clean($id));

        $url = URLAPI . "/v1/member/manualActivation?id=".$id_member;
		$response = expatAPI($url);
        $result = $response->result;

        // echo '<pre>'.print_r($response,true).'</pre>';
        // die;    

        if($response->status == 200){
            $this->session->set_flashdata('success', $result->messages);
			redirect('member');
			return;
        }else{
            $this->session->set_flashdata('error', $result->messages->error);
            redirect('member');
            return;
        }
    }

    public function membership()
    {
        
        $data = array(
            'title'             => NAMETITLE . ' - Membership',
            'content'           => 'admin/member/membership',
            'extra'             => 'admin/member/js/_js_membership',
            'master_active'     => 'active',
            'master_in'         => 'in',
            'dropdown_membership'   => 'text-expat-green'
        );

        $this->load->view('layout/wrapper', $data);
    }

    public function list_membership()
    {
        $url = URLAPI . "/v1/settings/get_setting";    
        $response = expatAPI($url)->result->messages;

        $bronze = array();
        $silver = array();
        $gold = array();
        $platinum = array();

        foreach($response as $dt){
            if($dt->content == 'Bronze' || $dt->content == 'poin_bronze') {
                if($dt->content == 'Bronze'){
                    $temp_bronze['tipe'] = 'Bronze';
                    $temp_bronze['deskripsi'] = $dt->value;
                }else{
                    $temp_bronze['minpoin'] = $dt->value;
                }
            } 
            if($dt->content == 'Silver' || $dt->content == 'poin_silver') {
                if($dt->content == 'Silver'){
                    $temp_silver['tipe'] = 'Silver';
                    $temp_silver['deskripsi'] = $dt->value;
                }else{
                    $temp_silver['minpoin'] = $dt->value;
                }
            } 
            if($dt->content == 'Gold' || $dt->content == 'poin_gold') {
                if($dt->content == 'Gold'){
                    $temp_gold['tipe'] = 'Gold';
                    $temp_gold['deskripsi'] = $dt->value;
                }else{
                    $temp_gold['minpoin'] = $dt->value;
                }
            }
            if($dt->content == 'Platinum' || $dt->content == 'poin_platinum') {
                if($dt->content == 'Platinum'){
                    $temp_platinum['tipe'] = 'Platinum';
                    $temp_platinum['deskripsi'] = $dt->value;
                }else{
                    $temp_platinum['minpoin'] = $dt->value;
                }
            } 
        }
        array_push($bronze, $temp_bronze);
        array_push($silver, $temp_silver);
        array_push($gold, $temp_gold);
        array_push($platinum, $temp_platinum);

        $result = array_merge($bronze, $silver, $gold, $platinum);

        echo json_encode($result);
    }

    public function edit_membership($tipe)
    {
        $type	= base64_decode($this->security->xss_clean($tipe));

        $url = URLAPI . "/v1/settings/get_setting";    
        $response = expatAPI($url)->result->messages;

        $bronze = array();
        $silver = array();
        $gold = array();
        $platinum = array();

        foreach($response as $dt){
            if($dt->content == 'Bronze' || $dt->content == 'poin_bronze') {
                if($dt->content == 'Bronze'){
                    $temp_bronze['tipe'] = 'Bronze';
                    $temp_bronze['deskripsi'] = $dt->value;
                }else{
                    $temp_bronze['minpoin'] = $dt->value;
                }
            } else if($dt->content == 'Silver' || $dt->content == 'poin_silver') {
                if($dt->content == 'Silver'){
                    $temp_silver['tipe'] = 'Silver';
                    $temp_silver['deskripsi'] = $dt->value;
                }else{
                    $temp_silver['minpoin'] = $dt->value;
                }
            } else if($dt->content == 'Gold' || $dt->content == 'poin_gold') {
                if($dt->content == 'Gold'){
                    $temp_gold['tipe'] = 'Gold';
                    $temp_gold['deskripsi'] = $dt->value;
                }else{
                    $temp_gold['minpoin'] = $dt->value;
                }
            } else if($dt->content == 'Platinum' || $dt->content == 'poin_platinum') {
                if($dt->content == 'Platinum'){
                    $temp_platinum['tipe'] = 'Platinum';
                    $temp_platinum['deskripsi'] = $dt->value;
                }else{
                    $temp_platinum['minpoin'] = $dt->value;
                }
            } 
        }
        array_push($bronze, $temp_bronze);
        array_push($silver, $temp_silver);
        array_push($gold, $temp_gold);
        array_push($platinum, $temp_platinum);

        $result = array_merge($bronze, $silver, $gold, $platinum);

        $final = array();
        foreach($result as $dt){
            if($dt['tipe'] == $type){
                $temp['tipe']   = $dt['tipe'];
                $temp['deskripsi']  = $dt['deskripsi'];
                $temp['minpoin']    = $dt['minpoin'];
                array_push($final, $temp);
            }
        }

        // echo '<pre>'.print_r($final,true).'</pre>';
        // die;

        $data = array(
            'title'             => NAMETITLE . ' - Edit Membership',
            'content'           => 'admin/member/edit_membership',
            'extra'             => 'admin/member/js/_js_membership',
            'master_active'     => 'active',
            'master_in'         => 'in',
            'dropdown_membership'   => 'text-expat-green',
            'result'            => $final,
        );

        $this->load->view('layout/wrapper', $data);
    }

    public function membership_proses()
    {
        $this->form_validation->set_rules('type', 'Type', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'trim|required');
        $this->form_validation->set_rules('minpoin', 'Min Poin', 'trim|required');
        
        $input      = $this->input;
        $type       = $this->security->xss_clean($this->input->post("type"));
        $description       = $this->security->xss_clean($this->input->post("description"));
        $minpoin       = $this->security->xss_clean($this->input->post("minpoin"));


        if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', $this->message->error_msg(validation_errors()));
			redirect("member/edit_membership/".base64_encode($type));
			return;
		}

        $mdata = array(
            "type"      => $type,
            "description" => $description,
            "minpoin"       => $minpoin
        );

        $url = URLAPI . "/v1/settings/updatemembership";
		$response = expatAPI($url, json_encode($mdata));
        $result = $response->result;

        if($response->status == 200) {
            $this->session->set_flashdata('success', $result->messages);
			redirect('member/membership');
			return;
        }else{
            $this->session->set_flashdata('error', $result->messages->error);
			redirect("member/edit_membership/".base64_encode($type));
			return;
        }
        // echo '<pre>'.print_r($response,true).'</pre>';
        // die;

    }

}