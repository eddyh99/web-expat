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
                    "id" => $dt->memberid,
                    "qrmember" => $dt->qrmember,
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
                    "id" => $dt->memberid,
                    "qrmember" => $dt->qrmember,
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
                    "id" => $dt->memberid,
                    "qrmember" => $dt->qrmember,
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
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[100]');
		$this->form_validation->set_rules('passwd', 'Password', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[100]');
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
		$this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[100]');
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
            if ($dt->content == 'Bronze' || $dt->content == 'poin_bronze' || 
                $dt->content == 'step1_bronze' || $dt->content == 'step2_bronze' || 
                $dt->content == 'step3_bronze' || $dt->content == 'step4_bronze' ||
                $dt->content == 'step5_bronze' || $dt->content == 'step6_bronze')
            {

                if($dt->content == 'Bronze'){
                    $temp_bronze['tipe'] = 'Bronze';
                    $temp_bronze['deskripsi'] = $dt->value;
                }else if($dt->content == 'poin_bronze'){
                    $temp_bronze['minpoin'] = $dt->value;
                }else{
                    $temp_bronze[str_replace("_bronze", "", $dt->content)] = $dt->value;
                }
            } 
            else if( $dt->content == 'Silver' || $dt->content == 'poin_silver' || 
                    $dt->content == 'step1_silver' || $dt->content == 'step2_silver' || 
                    $dt->content == 'step3_silver' || $dt->content == 'step4_silver' ||
                    $dt->content == 'step5_silver' || $dt->content == 'step6_silver') 
            {
                if($dt->content == 'Silver'){
                    $temp_silver['tipe'] = 'Silver';
                    $temp_silver['deskripsi'] = $dt->value;
                }else if($dt->content == 'poin_silver'){
                    $temp_silver['minpoin'] = $dt->value;
                }else{
                    $temp_silver[str_replace("_silver", "", $dt->content)] = $dt->value;
                }
            } 
            else if($dt->content == 'Gold' || $dt->content == 'poin_gold'  || 
                    $dt->content == 'step1_gold' || $dt->content == 'step2_gold' || 
                    $dt->content == 'step3_gold' || $dt->content == 'step4_gold' ||
                    $dt->content == 'step5_gold' || $dt->content == 'step6_gold') 
            {
                if($dt->content == 'Gold'){
                    $temp_gold['tipe'] = 'Gold';
                    $temp_gold['deskripsi'] = $dt->value;
                }else if($dt->content == 'poin_gold'){
                    $temp_gold['minpoin'] = $dt->value;
                }else{
                    $temp_gold[str_replace("_gold", "", $dt->content)] = $dt->value;
                }
            } 
            else if($dt->content == 'Platinum' || $dt->content == 'poin_platinum'|| 
                    $dt->content == 'step1_platinum' || $dt->content == 'step2_platinum' || 
                    $dt->content == 'step3_platinum' || $dt->content == 'step4_platinum' ||
                    $dt->content == 'step5_platinum' || $dt->content == 'step6_platinum') 
            {
                if($dt->content == 'Platinum'){
                    $temp_platinum['tipe'] = 'Platinum';
                    $temp_platinum['deskripsi'] = $dt->value;
                }else if($dt->content == 'poin_platinum'){
                    $temp_platinum['minpoin'] = $dt->value;
                }else{
                    $temp_platinum[str_replace("_platinum", "", $dt->content)] = $dt->value;
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
                $temp['tipe']       = $dt['tipe'];
                $temp['deskripsi']  = $dt['deskripsi'];
                $temp['minpoin']    = $dt['minpoin'];
                $temp['step1']    = $dt['step1'];
                $temp['step2']    = $dt['step2'];
                $temp['step3']    = $dt['step3'];
                $temp['step4']    = $dt['step4'];
                $temp['step5']    = $dt['step5'];
                $temp['step6']    = $dt['step6'];
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
        $this->form_validation->set_rules('step1', 'Step 1', 'trim|required');
        $this->form_validation->set_rules('step2', 'Step 2', 'trim|required');
        $this->form_validation->set_rules('step3', 'Step 3', 'trim|required');
        $this->form_validation->set_rules('step4', 'Step 4', 'trim|required');
        $this->form_validation->set_rules('step5', 'Step 5', 'trim|required');
        $this->form_validation->set_rules('step6', 'Step 6', 'trim|required');
        
        $input          = $this->input;
        $type           = $this->security->xss_clean($this->input->post("type"));
        $description    = $this->security->xss_clean($this->input->post("description"));
        $minpoin        = $this->security->xss_clean($this->input->post("minpoin"));
        $step1          = $this->security->xss_clean($this->input->post("step1"));
        $step2          = $this->security->xss_clean($this->input->post("step2"));
        $step3          = $this->security->xss_clean($this->input->post("step3"));
        $step4          = $this->security->xss_clean($this->input->post("step4"));
        $step5          = $this->security->xss_clean($this->input->post("step5"));
        $step6          = $this->security->xss_clean($this->input->post("step6"));


        if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', $this->message->error_msg(validation_errors()));
			redirect("member/edit_membership/".base64_encode($type));
			return;
		}

        $mdata = array(
            "type"          => $type,
            "description"   => $description,
            "minpoin"       => $minpoin,
            "step1"         => $step1,
            "step2"         => $step2,
            "step3"         => $step3,
            "step4"         => $step4,
            "step5"         => $step5,
            "step6"         => $step6,
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