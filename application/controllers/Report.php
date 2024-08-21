<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
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
        die;
    }

    public function members()
    {
        // $url = URLAPI . "/v1/member/get_allmember?role=member";
		// $response = expatAPI($url)->result->messages;

        // $resultActive = array();
        // foreach($response as $dt){
        //     if($dt->status == 'active'){
        //         $mdata = array(
        //             "id" => $dt->id,
        //             "qrmember" => $dt->memberid,
        //             "email" => $dt->email,
        //             "nama" => $dt->nama,
        //             "dob" => $dt->dob,
        //             "gender" => $dt->gender,
        //             "status" => $dt->status,
        //             "membership" => $dt->membership,
        //         );
        //         array_push($resultActive, $mdata);
        //     }
        // }

        // echo json_encode($resultActive);   

        // echo '<pre>'.print_r($resultActive,true).'</pre>';
        // die;
        $data = array(
            'title'             => NAMETITLE . ' - Report Members',
            'content'           => 'admin/report/report_member',
            'extra'             => 'admin/report/js/_js_members',
            'rmembers_active'   => 'active',
        );
        $this->load->view('layout/wrapper', $data);
    }

    public function get_all_member()
    {
		$url = URLAPI . "/v1/member/get_allmember?role=member";
		$response = expatAPI($url)->result->messages;

        $resultActive = array();
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
            }
        }

        echo json_encode($resultActive);        
    }

    public function summarymember($id)
    {

        $idmember	= base64_decode($this->security->xss_clean($id));

        $url = URLAPI . "/v1/member/get_byid?id=".$idmember;
		$result_member = expatAPI($url)->result->messages;

        // $token = sha1(utf8_encode($result_member->email . $result_member->passwd)); 


        // $url_memberm 		= URLAPI . "/v1/mobile/member/get_userdetail";
		// $response_memberm 	= mobileAPI($url_memberm, $mdata = NULL, $token);
        // $result_memberm      = $response_memberm->result->messages;



        $data = array(
            'title'             => NAMETITLE . ' - Report Summary Member',
            'content'           => 'admin/report/report_summary_member',
            'extra'             => 'admin/report/js/_js_reportmember',
            'member'            => $result_member,
            // 'memberm'           => $result_memberm,
            'idmember'          => $idmember,
            'rmembers_active'   => 'active',
        );
        $this->load->view('layout/wrapper', $data);
    }

    public function get_list_topup()
    {
        $startmonth     = $this->security->xss_clean($this->input->post('startmonth'));
        $endmonth       = $this->security->xss_clean($this->input->post('endmonth'));
        $idmember       = $this->security->xss_clean($this->input->post('idmember'));


        $url = URLAPI . "/v1/history/getdetail_history?start_date=".$startmonth."&end_date=".$endmonth."&idmember=".$idmember;
        $result = expatAPI($url)->result->messages->topup;  


        echo json_encode($result);
    }


    public function get_list_order()
    {
        $startmonth     = $this->security->xss_clean($this->input->post('startmonth'));
        $endmonth       = $this->security->xss_clean($this->input->post('endmonth'));
        $idmember       = $this->security->xss_clean($this->input->post('idmember'));


        $url = URLAPI . "/v1/history/getdetail_history?start_date=".$startmonth."&end_date=".$endmonth."&idmember=".$idmember;
        $result = expatAPI($url)->result->messages->history;  


        echo json_encode($result);
    }
}