<?php
defined('BASEPATH') or exit('No direct script access allowed');

class History extends CI_Controller
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
            'title'             => NAMETITLE . ' - History Topup',
            'content'           => 'admin/history/history_topup',
            'extra'             => 'admin/history/js/_js_historytopup',
            'history_active'     => 'active',
            'history_in'         => 'in',
            'dropdown_htopup'    => 'text-expat-green'
        );
        $this->load->view('layout/wrapper', $data);

    }

    public function get_history_topup()
    {
            $tanggal    = $this->security->xss_clean($this->input->post('tanggal'));
            $status     = $this->security->xss_clean($this->input->post('status'));
    
            if (empty($tanggal)){
                $start      = date("Y-m-d");
                $end        = date("Y-m-d");
            }else{
                $newtanggal	= explode("-",$tanggal);
                $start      = date_format(date_create($newtanggal[0]),"Y-m-d");
                $end        = date_format(date_create($newtanggal[1]),"Y-m-d");
            }

            $url = URLAPI . "/v1/history/gethistoryTopup?start_date=".$start."&end_date=".$end;
            $result = expatAPI($url)->result->messages;  

            echo json_encode($result);
    }

    public function approve_topup($id_member, $invoice)
    {
        $id_member = base64_decode($this->security->xss_clean($id_member));
        $invoice = base64_decode($this->security->xss_clean($invoice));

        $mdata = array(
            "invoice"   => $invoice,
            "memberid"  => $id_member
        );


        $url = URLAPI . "/v1/history/setPaymentStatus";
		$response = expatAPI($url,  json_encode($mdata));
        $result = $response->result;


        if($response->status == 200){
            $this->session->set_flashdata('success', "Approved");
        }else{
            $this->session->set_flashdata('error', $result->messages->error);
        }
        redirect('history');
    }


    public function order()
    {
        $data = array(
            'title'             => NAMETITLE . ' - History Order',
            'content'           => 'admin/history/history_order',
            'extra'             => 'admin/history/js/_js_historyorder',
            'history_active'     => 'active',
            'history_in'         => 'in',
            'dropdown_horder'    => 'text-expat-green'
        );
        $this->load->view('layout/wrapper', $data);

    }

    public function get_history_order()
    {
            $tanggal    = $this->security->xss_clean($this->input->post('tanggal'));
            $idcabang     = $this->security->xss_clean($this->input->post('idcabang'));
    
            if (empty($tanggal)){
                $start      = date("Y-m-d");
                $end        = date("Y-m-d");
            }else{
                $newtanggal	= explode("-",$tanggal);
                $start      = date_format(date_create($newtanggal[0]),"Y-m-d");
                $end        = date_format(date_create($newtanggal[1]),"Y-m-d");
            }

            $url = URLAPI . "/v1/history/getTransaksi?start_date=".$start."&end_date=".$end."&is_paid=yes&cabang=".$idcabang;
            $result = expatAPI($url)->result->messages;  

            echo json_encode($result);
    }

    public function detail_order($getInvoice)
    {   

        $invoice	= base64_decode($this->security->xss_clean($getInvoice));
        
        $url = URLAPI . "/v1/history/detailTransaksi?invoice=".$invoice;
		$result = expatAPI($url)->result->messages;


        $urlStaff = URLAPI . "/v1/user/getall_staff";
		$resultStaff = expatAPI($urlStaff)->result->messages;

        // echo '<pre>'.print_r($resultStaff,true).'</pre>';
        // die;

        
        $data = array(
            'title'             => NAMETITLE . ' - History Detail Order',
            'content'           => 'admin/history/history_detailorder',
            'extra'             => 'admin/history/js/_js_historyorder',
            'history_active'     => 'active',
            'history_in'         => 'in',
            'dropdown_horder'    => 'text-expat-green', 
            'detail'            => $result, 
            'staff'             => $resultStaff,
            'invoice'           => $invoice
        );
        
        $this->load->view('layout/wrapper', $data);

    }
    
    public function process_order(){
        $invoice        = $this->security->xss_clean($this->input->post('invoice'));
        $iddriver       = $this->security->xss_clean($this->input->post('id_driver'));
        
        $mdata=array(
                "invoice"     => $invoice,
                "id_driver"  => !empty($iddriver) ? $iddriver : null
            );
        $url = URLAPI . "/v1/history/process_order";
		$result = expatAPI($url,json_encode($mdata));
		print_r($result);
        
    }
}