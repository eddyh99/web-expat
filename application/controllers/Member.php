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
            'content'           => 'admin/master/member/index',
            'extra'             => 'admin/master/member/js/_js_index',
            'member_active'     => 'active',
            'dropdown_stmember' => 'text-success',
        );
        $this->load->view('layout/wrapper-dashboard', $data);

    }

    
    public function list_allmember()
    {
        $status     = $this->security->xss_clean($this->input->post('status'));
		$url = URLAPI . "/v1/member/get_allmember?role=member";
		$response = expatAPI($url)->result->messages;

        $resultActive = array();
        $resultNew = array();
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
            }
        }

        if($status == 'active'){
            echo json_encode($resultActive);        
        }else if($status == 'new'){
            echo json_encode($resultNew);        
        }

    }
}