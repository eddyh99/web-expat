<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
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
            'title'         => NAMETITLE . ' - List User',
            'content'       => 'admin/user/index',
            'extra'         => 'admin/user/js/_js_index',
            'user_active'    => 'active',
        );
        $this->load->view('layout/wrapper-dashboard', $data);

    }

    public function list_alluser()
    {
		$url = URLAPI . "/v1/user/get_alluser";
		$result = expatAPI($url)->result->message;
        echo json_encode($result);        

    }

    public function add_user()
    {
        $data = array(
            'title'         => NAMETITLE . ' - Add User',
            'content'       => 'admin/user/add_user',
            'extra'         => 'admin/user/js/_js_index',
            'user_active'    => 'active',
        );
        $this->load->view('layout/wrapper-dashboard', $data);
    }

    public function adduser_process()
    {
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('passwd', 'Password', 'trim|required');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('role', 'Role', 'trim|required');


        if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error_validation', $this->message->error_msg(validation_errors()));
			redirect("user/tambah_user");
			return;
		}

        $input      = $this->input;
        $username   = $this->security->xss_clean($input->post('username'));
        $passwd     = $this->security->xss_clean($input->post('passwd'));
        $name       = $this->security->xss_clean($input->post('name'));
        $role       = $this->security->xss_clean($input->post('role'));

        $mdata = array(
            "username"  => $username, 
            "passwd"    => sha1($passwd),
            "nama"      => $name,
            "role"      => $role,
        );

		$url = URLAPI . "/v1/user/addUser";
		$response = expatAPI($url, json_encode($mdata));
        $result = $response->result;

        if($response->status == 200) {
            $this->session->set_flashdata('success', $result->messages);
			redirect('user');
			return;
        }else{
            $this->session->set_flashdata('error', $result->messages->error);
			redirect('user/add_user');
			return;
        }

    }

    public function edit_user($username)
    {
        $username	= base64_decode($this->security->xss_clean($username));

        $url = URLAPI . "/v1/user/get_byusername?username=".$username;
		$result = expatAPI($url)->result->messages;


        $data = array(
            'title'             => NAMETITLE . ' - Edit user',
            'content'           => 'admin/user/edit_user',
            'extra'             => 'admin/user/js/_js_index',
            'user_active'       => 'active',
            'user'              => $result,
        );

        $this->load->view('layout/wrapper-dashboard', $data);
    }
    
    public function edituser_process()
    {
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('passwd', 'Password', 'trim');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('role', 'Role', 'trim|required');

        $input      = $this->input;
        $urisegment   = $this->security->xss_clean($input->post('urisegment'));

        if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error_validation', $this->message->error_msg(validation_errors()));
            redirect('user/edit_user/'.$urisegment);
			return;
		}

        $username   = $this->security->xss_clean($input->post('username'));
        $passwd     = $this->security->xss_clean($input->post('passwd'));
        $name     = $this->security->xss_clean($input->post('name'));
        $role       = $this->security->xss_clean($input->post('role'));
        

        if (empty($passwd)){
            $mdata = array(
                "username"  => $username, 
                "nama"      => $name,
                "role"      => $role,
            );
        }else{
            $mdata = array(
                "username"  => $username, 
                "passwd"    => sha1($passwd),
                "nama"      => $name,
                "role"      => $role,
            );
        
        }
        $url = URLAPI . "/v1/user/updateUser";
		$response = expatAPI($url, json_encode($mdata));
        $result = $response->result;


        if($response->status == 200){
            $this->session->set_flashdata('success', $result->messages);
			redirect('user');
			return;
        }else{
            $this->session->set_flashdata('error', $result->messages->error);
            redirect('user/edit_user/'.$urisegment);
            return;
        }
    }

    public function delete($username)
    {
        $username_delete = base64_decode($this->security->xss_clean($username));

        if ($username_delete=="admin"){
            $this->session->set_flashdata('success', "Admin can't be deleted");
            redirect("user");
            return;
        }

        $url = URLAPI . "/v1/user/deleteUser?username=".$username_delete;
		$response = expatAPI($url);
        $result = $response->result;


        if($response->status == 200){
            $this->session->set_flashdata('success', $result->messages);
			redirect('user');
			return;
        }else{
            $this->session->set_flashdata('error', $result->messages->error);
            redirect('user');
            return;
        }


    }

}
