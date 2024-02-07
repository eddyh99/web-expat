<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!isset($this->session->userdata['logged_status'])) {
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

    public function list_user()
    {
		$url = URLAPI . "/v1/user/getUser";
		$result = expat($url);
        echo json_encode($result);        
    }

    public function tambah_user()
    {
        $data = array(
            'title'         => NAMETITLE . ' - Tambah User',
            'content'       => 'admin/user/tambah_user',
            'extra'         => 'admin/user/js/_js_index',
            'user_active'    => 'active',
        );
        $this->load->view('layout/wrapper-dashboard', $data);
    }

    public function tambah_process()
    {
        /*@todo 
            role isinya admin, kasir
        */

        $input      = $this->input;
        $username   = $this->security->xss_clean($input->post('username'));
        $passwd     = $this->security->xss_clean($input->post('passwd'));
        $role       = $this->security->xss_clean($input->post('role'));

        $datas = array(
            "username"  => $username, 
            "passwd"    => sha1($passwd),
            "role"      => $lokasi,
        );

		$url = URLAPI . "/v1/user/addUser";
		$result = expat($url, json_encode($mdata));

        if($result['code'] == 200) {
            $this->session->set_flashdata('success', $this->message->success_msg());
			redirect('user');
			return;
        }else{
            $this->session->set_flashdata('error', $this->message->error_msg($result["message"]));
			redirect('user/tambah_user');
			return;
        }

    }

    public function edit_user($id)
    {
        $id	= base64_decode($this->security->xss_clean($id));

        $url = URLAPI . "/v1/user/getUserbyid?user_id=".$id;
		$result = expat($url);

        $data = array(
            'title'             => NAMETITLE . ' - Edit user',
            'content'           => 'admin/user/edit_user',
            'extra'             => 'admin/user/js/_js_index',
            'user_active'       => 'active',
            'user'              => $result,
        );

        $this->load->view('layout/wrapper-dashboard', $data);
    }
    
    public function edit_process()
    {
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('passwd', 'Password', 'trim');
		$this->form_validation->set_rules('lokasi', 'Location', 'trim|required');


        if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error_validation', $this->message->error_msg(validation_errors()));
            redirect('user/edit_user/'.base64_encode($username));
			return;
		}


        $input      = $this->input;
        $username   = $this->security->xss_clean($input->post('username'));
        $passwd     = $this->security->xss_clean($input->post('passwd'));
        $role       = $this->security->xss_clean($input->post('role'));
        
        //kosongkan password jika tidak mengganti password
        if (empty($passwd)){
            $datas = array(
                "username"  => $username, 
                "role"      => $role,
            );
        }else{
            $datas = array(
                "username"  => $username, 
                "passwd"    => sha1($passwd),
                "role"      => $role,
            );
        }
        $url = URLAPI . "/v1/user/updateUser";
		$result = expat($url, json_encode($mdata));

        if($result['code'] == 200){
            $this->session->set_flashdata('success', $this->message->success_edit_msg());
			redirect('user');
			return;
        }else{
            $this->session->set_flashdata('error', $this->message->success_edit_msg());
            redirect('user/edit_user/'.base64_encode($id_edit));
            return;
        }
    }

    public function hapus($id)
    {
        $id_delete = base64_decode($this->security->xss_clean($id));
        if ($id_delete=="admin"){
            $this->session->set_flashdata('success', "Admin can't be deleted");
            redirect("user");
            return;
        }

        $url = URLAPI . "/v1/user/deleteUser?user_id=".$id_delete;
		$result = expat($url);

        if($result['code'] = 200){
            $this->session->set_flashdata('success', $this->message->delete_msg());
			redirect('user');
			return;
        }else{
            $this->session->set_flashdata('error', $this->message->error_delete_msg());
            redirect('user');
            return;
        }


    }

}
