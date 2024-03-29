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

		// $segment = $this->uri->segment('1');
		// echo '<pre>'.print_r(gettype($segment),true).'</pre>';
		// die;

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

		$mdata = array(
			'username'	=> $username,
			'passwd'	=> sha1($password),
		);

		$url = URLAPI . "/auth/expatsignin";
		$response = expatAPI($url, json_encode($mdata));
		$result = $response->result->messages;
		// echo '<pre>'.print_r($response,true).'</pre>';
		// die;
		
		if (@$response->status != 200) {
			$this->session->set_flashdata('error', $result->error);
			redirect("/");
			return;
		}

		
		$temp_session = array(
			'username'  => $result->username,
			'role'      => $result->role,
			'is_login'  => true
		);

		$this->session->set_userdata('logged_user', $temp_session);
		$this->session->set_flashdata('success_login', "Selamat datang <b>".$result->username."</b>");
		redirect('dashboard');

	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('/');
	}
}
