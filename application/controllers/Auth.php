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



	// ================= FORGOT PASSWORD FOR MOBILE =================

	public function send_email($email)
	{
		$email = urldecode($email);
		$email =  $this->security->xss_clean($email);
		$subject = "Reset Your Expat. Roasters Apps Password";

		$url = URLAPI . "/auth/get_resettoken?email=".$email;
		$response = expatAPI($url);
		$otp = $response->result->messages;

		$message = "
		<!DOCTYPE html>
		<html lang='en'>

		<head>
			<meta name='color-scheme' content='light'>
			<meta name='supported-color-schemes' content='light'>
			<title>Forgot Password Expat. Roasters Apps</title>
		</head>

		<body>
			<div style='
			max-width: 420px;
			margin: 0 auto;
			position: relative;
			padding: 1rem;
			'>
				<div style='
				text-align: center;
				padding: 3rem;
				'>
					<h3 style='
					font-weight: 600;
					font-size: 30px;
					line-height: 45px;
					color: #000000;
					margin-bottom: 1rem;
					text-align: center;
					'>
						Hi,
					</h3>
					<img src='" . base_url() . "assets/img/email_cover.png' alt='Expat. Roasters Apps ' height='140'>
				</div>

				<div style='
				text-align: center;
				padding-bottom: 1rem;
				'>
					<p style='
					font-weight: 400;
					font-size: 14px;
					color: #000000;
					'>
						We received a request OTP to reset your password for your Expat. Roasters account. To proceed with your request, please use the following OTP
					</p>
					<h2 style='letter-spacing: 12px;'>$otp</h2>
					<p style='
					font-weight: 400;
					font-size: 14px;
					color: #000000;
					'>
						This code is valid for the next 1 minutes. If you didn't request a password reset, please ignore this email or contact our support team.

					</p>
					<p style='
					font-weight: 400;
					font-size: 14px;
					color: #000000;
					'>
						Best regards,<br>  
						The Expat. Roasters Team

					</p>
				</div>
				<hr>
				<hr>
				<p style='
				text-align: center;
				font-weight: 400;
				font-size: 12px;
				color: #999999;
				'>
					Copyright © " . date('Y') . "
				</p>
			</div>
		</body>
		</html>";

		sendmail($email, $subject, $message, $this->phpmailer_lib->load());
	}




}
