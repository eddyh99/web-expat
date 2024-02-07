<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{	

		$data = array(
			'title'     => NAMETITLE . ' - Login',
			'content'   => 'auth/login/index',
			'extra'		=> 'auth/login/js/_js_index',
		);
		$this->load->view('layout/wrapper', $data);
	}


	public function auth_login()
	{
		$this->form_validation->set_rules('username', 'Username', 'trim|required|max_length[10]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		// $this->form_validation->set_rules('role_login', 'Role', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error_validation', $this->message->error_msg(validation_errors()));
			redirect("/");
			return;
		}

		$input = $this->input;
		$username = $this->security->xss_clean($input->post('username'));
		$password = $this->security->xss_clean($input->post('password'));
		// $role_login = $this->security->xss_clean($input->post('role_login'));

		$datas = array(
			'username'	=> $username,
			'password'	=> $password,
			// 'role'		=> $role_login
		);

		$url = URLAPI . "/v1/auth/signin";
		$result = expat($url, json_encode($mdata));
		if (@$result->code != 200) {
			$this->session->set_flashdata('failed', $result->message);
			redirect("/");
			return;
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('/');
	}
}
