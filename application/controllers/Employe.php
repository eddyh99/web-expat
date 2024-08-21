<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Employe extends CI_Controller
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
            'title'             => NAMETITLE . ' - Employe',
            'content'           => 'admin/employe/index',
            'extra'             => 'admin/employe/js/_js_index',
            'employee_active'   => 'active',
        );

        $this->load->view('layout/wrapper', $data);

    }

    
    public function list_allemploye()
    {
        // $status     = $this->security->xss_clean($this->input->post('status'));
		$url = URLAPI . "/v1/member/get_allmember?role=pegawai";
		$response = expatAPI($url)->result->messages;   
        // $resultNew = array();
        // $resultDisabled = array();
        $resultActive = array();
        foreach($response as $dt){
            if($dt->status == 'active'){
                $mdata = array(
                    "memberid" => $dt->memberid,
                    "email" => $dt->email,
                    "nama" => $dt->nama,
                    "dob" => $dt->dob,
                    "gender" => $dt->gender,
                    "membership" => $dt->membership,
                    "is_driver" => $dt->is_driver,
                    "plafon" => $dt->plafon,
                    "status" => $dt->status,
                );
                array_push($resultActive, $mdata);
            }
        }

        echo json_encode($resultActive);  
              

    }

    public function add_employe()
    {
        $data = array(
            'title'         => NAMETITLE . ' - Add Employe',
            'content'       => 'admin/employe/add_employe',
            'extra'         => 'admin/employe/js/_js_index',
            'employee_active'   => 'active',
        );
        $this->load->view('layout/wrapper', $data);
    }

    public function addemploye_process()
    {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[100]');
		$this->form_validation->set_rules('passwd', 'Password', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('gender', 'Gender', 'trim|required');
		$this->form_validation->set_rules('is_driver', 'Is Driver', 'trim|required');
        $this->form_validation->set_rules('plafon', 'Plafon', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error_validation', $this->message->error_msg(validation_errors()));
			redirect("employe/add_employe");
			return;
		}

        $input      = $this->input;
        $email      = $this->security->xss_clean($input->post('email'));
        $passwd     = $this->security->xss_clean($input->post('passwd'));
        $name       = $this->security->xss_clean($input->post('name'));
        $gender     = $this->security->xss_clean($input->post('gender'));
        $is_driver  = $this->security->xss_clean($input->post('is_driver'));
        $plafon     = $this->security->xss_clean($input->post('plafon'));

        $mdata = array(
            "email"         => $email,
            "passwd"        => sha1($passwd),
            "nama"          => $name,
            "gender"        => $gender,
            "role"          => 'pegawai',
            "plafon"        => $plafon,
            'membership'    => 'bronze',
            "is_driver"     => $is_driver,
        );

        
		$url = URLAPI . "/v1/member/addMember";
		$response = expatAPI($url, json_encode($mdata));
        $result = $response->result;

        // echo '<pre>'.print_r($response,true).'</pre>';
        // die;

        if($response->status == 200) {
            $this->session->set_flashdata('success', $result->messages);
			redirect('employe');
			return;
        }else{
            $this->session->set_flashdata('error', $result->messages->error);
			redirect('employe/add_employe');
			return;
        }
    } 

    public function edit_employe($id)
    {
        $id_member	= base64_decode($this->security->xss_clean($id));

        $url = URLAPI . "/v1/member/get_byid?id=".$id_member;
		$result = expatAPI($url)->result->messages;
        $data = array(
            'title'             => NAMETITLE . ' - Edit Employe',
            'content'           => 'admin/employe/edit_employe',
            'extra'             => 'admin/employe/js/_js_index',
            'member'            => $result,
            'employee_active'   => 'active',
        );

        $this->load->view('layout/wrapper', $data);
    }


    public function editemploye_process()
    {
		$this->form_validation->set_rules('passwd', 'Password', 'trim|max_length[100]');
		$this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('gender', 'Gender', 'trim|required');
		$this->form_validation->set_rules('is_driver', 'Driver', 'trim|required');
		$this->form_validation->set_rules('plafon', 'Plafon', 'trim|required');

        $input      = $this->input;
        $urisegment   = $this->security->xss_clean($input->post('urisegment'));

        if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error_validation', $this->message->error_msg(validation_errors()));
            redirect('employe/edit_employe/'.$urisegment);
			return;
		}

        $id         = base64_decode($urisegment);
        $oldpass    = $this->security->xss_clean($input->post('oldpass'));
        $name       = $this->security->xss_clean($input->post('name'));
        $newpasswd  = $this->security->xss_clean($input->post('passwd'));
        $gender     = $this->security->xss_clean($input->post('gender'));
        $is_driver  = $this->security->xss_clean($input->post('is_driver'));
        $plafon     = $this->security->xss_clean($input->post('plafon'));

        

        if (empty($newpasswd)){
            $mdata = array(
                "nama"          => $name,
                "gender"        => $gender,
                "membership"    => 'bronze',
                "is_driver"     => $is_driver,
                "plafon"        => $plafon,
                "role"          => 'pegawai'
            );
        }else{
            $mdata = array(
                "passwd"        => sha1($newpasswd),
                "nama"          => $name,
                "gender"        => $gender,
                "membership"    => 'bronze',
                "is_driver"     => $is_driver,
                "plafon"        => $plafon,
                "role"          => 'pegawai'
            );
        
        }
        $url = URLAPI . "/v1/member/updateMember?id=".$id;
		$response = expatAPI($url, json_encode($mdata));
        $result = $response->result;
        //print_r($response);die;

        if($response->status == 200){
            $this->session->set_flashdata('success', $result->messages);
			redirect('employe');
			return;
        }else{
            $this->session->set_flashdata('error', $result->messages->error);
            redirect('employe/edit_employe/'.$urisegment);
            return;
        }
    }



    public function delete($id)
    {
        $id_member = base64_decode($this->security->xss_clean($id));

        $url = URLAPI . "/v1/member/deleteMember?id=".$id_member;
		$response = expatAPI($url);
        $result = $response->result;

        // echo '<pre>'.print_r($response,true).'</pre>';
        // die;    

        if($response->status == 200){
            $this->session->set_flashdata('success', $result->messages);
			redirect('employe');
			return;
        }else{
            $this->session->set_flashdata('error', $result->messages->error);
            redirect('employe');
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

    public function assign_staff()
    {
  

        $data = array(
            'title'             => NAMETITLE . ' - Assign Staff',
            'content'           => 'admin/employe/assignstaff/index',
            'extra'             => 'admin/employe/assignstaff/js/_js_index',
            'assign_active'     => 'active',

        );

        $this->load->view('layout/wrapper', $data);
    }

    public function list_assignstaff()
    {

		$url = URLAPI . "/v1/user/getall_staff";
		$response = expatAPI($url)->result->messages;   

        echo json_encode($response);  
    }

    public function add_assignstaff()
    {
        $urlStaff = URLAPI . "/v1/member/get_allmember?role=pegawai";
		$resultStaff = expatAPI($urlStaff)->result->messages;  
        
        
        $urlCabang = URLAPI . "/v1/outlet/get_allcabang";
		$resultCabang = expatAPI($urlCabang)->result->messages;  


        $data = array(
            'title'             => NAMETITLE . ' - Add Assign Staff',
            'content'           => 'admin/employe/assignstaff/add_assignstaff',
            'extra'             => 'admin/employe/assignstaff/js/_js_index',
            'master_active'     => 'active',
            'master_in'         => 'in',
            'dropdown_assignstaff'  => 'text-expat-green',
            'staff'             => $resultStaff,
            'cabang'             => $resultCabang,
        );

        $this->load->view('layout/wrapper', $data);
    }

    public function addproccess_assignstaff()
    {
        $this->form_validation->set_rules('staff', 'Staff', 'trim|required');
		$this->form_validation->set_rules('outlet', 'Outlet', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', $this->message->error_msg(validation_errors()));
			redirect("employe/add_assignstaff");
			return;
		}

        $input      = $this->input;
        $idstaff      = $this->security->xss_clean($input->post('staff'));
        $idoutlet     = $this->security->xss_clean($input->post('outlet'));

        $mdata = array(
            "id_staff"      => $idstaff,
            "cabangid"      => $idoutlet
        );

        $url = URLAPI . "/v1/user/addStaff";
		$response = expatAPI($url, json_encode($mdata));
        $result = $response->result;

        // echo '<pre>'.print_r($response,true).'</pre>';
        // die;    

        if($response->status == 200){
            $this->session->set_flashdata('success', $result->messages);
			redirect('employe/assign_staff');
			return;
        }else{
            $this->session->set_flashdata('error', $result->messages->error);
            redirect('employe/add_assignstaff');
            return;
        }

    }

    public function delete_assignstaff($idstaff, $idcabang)
    {
        $id_staff = base64_decode($this->security->xss_clean($idstaff));
        $id_cabang = base64_decode($this->security->xss_clean($idcabang));

        $url = URLAPI . "/v1/user/deleteStaff?id_staff=".$id_staff."&cabangid=".$id_cabang;
		$response = expatAPI($url);
        $result = $response->result;

        // echo '<pre>'.print_r($response,true).'</pre>';
        // die;    

        if($response->status == 200){
            $this->session->set_flashdata('success', $result->messages);
			redirect('employe/assign_staff');
			return;
        }else{
            $this->session->set_flashdata('error', $result->messages->error);
            redirect('employe/assign_staff');
            return;
        }
    }
}