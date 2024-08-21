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
        $url = URLAPI . "/v1/outlet/get_allcabang";
		$result = expatAPI($url)->result->messages;

    
        $data = array(
            'title'             => NAMETITLE . ' - History Order',
            'content'           => 'admin/history/history_order',
            'extra'             => 'admin/history/js/_js_historyorder',
            'history_active'     => 'active',
            'history_in'         => 'in',
            'dropdown_horder'    => 'text-expat-green',
            'cabang'             => $result
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

        // $final_detail = array();
        
        // foreach($result as $key => $dt){
        //     if($dt->prd_group == 0){
        //         $temp = array();

        //         $temp['imgprod']        = $dt->imgprod;
        //         $temp['picture']        = $dt->picture;
        //         $temp['nama_produk']    = $dt->nama;
        //         $temp['jumlah']         = $dt->jumlah;
        //         $temp['price_produk']   = $dt->harga;
        //     }else{
        //         if($dt->tipe == 'produk'){
        //             array_push($final_detail, $temp);
        //             $temp = array();
        //             $temp['imgprod']        = $dt->imgprod;
        //             $temp['picture']        = $dt->picture;
        //             $temp['nama_produk']    = $dt->nama;
        //             $temp['jumlah']         = $dt->jumlah;
        //             $temp['price_produk']   = $dt->harga;
        //         }else if($dt->tipe == 'satuan'){
        //             $temp['nama_satuan']    = $dt->nama;
        //             $temp['price_satuan']   = $dt->harga;
        //         }else if($dt->tipe == 'optional'){
        //             $temp['nama_optional']    = $dt->nama;
        //             $temp['price_optional']   = $dt->harga;
        //         }else{
        //             $temp['nama_additional']    = $dt->nama;
        //             $temp['price_additional']   = $dt->harga;
        //         }
        //     }
        // }

        // echo '<pre>'.print_r($final_detail,true).'</pre>';
        // die;

        $multiple_detail = array();
        foreach ($result as $dt) {
            $multiple_detail[$dt->prd_group][] = $dt;
        }


        $final_detail = array();
        foreach($multiple_detail as $md){
            foreach($md as $dt){
                if($dt->tipe == 'produk'){
                    $temp['imgprod'] = $dt->imgprod;
                    $temp['picture'] = $dt->picture;
                    $temp['jumlah'] = $dt->jumlah;
                    $temp['id_pengiriman'] = $dt->id_pengiriman;
                    $temp['customer'] = $dt->customer;
                    $temp['almtcabang'] = $dt->almtcabang;
                    $temp['title'] = $dt->title;
                    $temp['phone'] = $dt->phone;
                    $temp['alamat'] = $dt->alamat;
                    $temp['note'] = $dt->note;
                    $temp['delivery_fee'] = $dt->delivery_fee;
                    $temp['cabang'] = $dt->cabang;
                    $temp['namadriver'] = $dt->namadriver;
                    $temp['tanggal'] = $dt->tanggal;
                    $temp['is_proses'] = $dt->is_proses;
                    $temp['is_paid'] = $dt->is_paid;
                }

                $temp['nama'.$dt->tipe] = $dt->nama;
                $temp['harga'.$dt->tipe] = $dt->harga;
            }

            $temp = (object) $temp;
            array_push($final_detail, $temp);
            $temp = array();
        }

        // echo '<pre>'.print_r($final_detail,true).'</pre>';
        // die;



        $data = array(
            'title'             => NAMETITLE . ' - History Detail Order',
            'content'           => 'admin/history/history_detailorder',
            'extra'             => 'admin/history/js/_js_historyorder',
            'history_active'     => 'active',
            'history_in'         => 'in',
            'dropdown_horder'    => 'text-expat-green', 
            'detail'            => $final_detail, 
            'staff'             => $resultStaff,
            'invoice'           => $invoice
        );
        
        $this->load->view('layout/wrapper', $data);

    }
    
    public function process_order(){
        $invoice        = $this->security->xss_clean($this->input->post('invoice'));
        $iddriver       = $this->security->xss_clean($this->input->post('id_driver'));
        $jenis          = $this->security->xss_clean($this->input->post('jenis'));
        

        if($jenis == 'delivery'){
            $this->form_validation->set_rules('invoice', 'Invoice', 'trim|required');
            $this->form_validation->set_rules('id_driver', 'Driver', 'trim|required');

        }else{
            $this->form_validation->set_rules('invoice', 'Invoice', 'trim|required');
        }


        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', $this->message->error_msg(validation_errors()));
            redirect("history/detail_order/".base64_encode($invoice));
            return;
        }

        $mdata=array(
            "invoice"     => $invoice,
            "id_driver"  => !empty($iddriver) ? $iddriver : null
        );
        
        $url = URLAPI . "/v1/history/process_order";
		$result = expatAPI($url,json_encode($mdata));

        if($result->status == 200) {
            if($jenis == 'delivery'){
                $this->session->set_flashdata('success', "Order Successfully Update");
            }else{
                $this->session->set_flashdata('success', "Order Successfully Pickup");
            }
            redirect("history/detail_order/".base64_encode($invoice));
            return;
        }else{
            $this->session->set_flashdata('error', $result->result->messages->error);
            redirect("history/detail_order/".base64_encode($invoice));
            return;
        }
    }

    public function member()
    {
        $url = URLAPI . "/v1/outlet/get_allcabang";
		$result = expatAPI($url)->result->messages;


        $data = array(
            'title'             => NAMETITLE . ' - History Member',
            'content'           => 'admin/history/history_member',
            'extra'             => 'admin/history/js/_js_historyorder',
            'history_active'     => 'active',
            'history_in'         => 'in',
            'dropdown_hmember'    => 'text-expat-green',
        );
        $this->load->view('layout/wrapper', $data);

    }
}