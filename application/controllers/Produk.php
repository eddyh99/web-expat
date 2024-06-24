<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produk extends CI_Controller
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
            'title'             => NAMETITLE . ' - Produk',
            'content'           => 'admin/produk/index',
            'extra'             => 'admin/produk/js/_js_index',
            'master_active'     => 'active',
            'master_in'         => 'in',
            'dpd_active'        => 'active',
            'dpd_in'            => 'in',
            'dpd_produk'        => 'text-expat-green'
        );
        $this->load->view('layout/wrapper', $data);

    }

    public function list_allproduk()
    {
		$url = URLAPI . "/v1/produk/get_allproduk";
		$result = expatAPI($url)->result->messages;
        echo json_encode($result);  
        die;      
    }

    public function add_produk()
    {
        $data = array(
            'title'         => NAMETITLE . ' - Add Produk',
            'content'       => 'admin/produk/add_produk',
            'extra'         => 'admin/produk/js/_js_index',
            'master_active' => 'active',
            'master_in'     => 'in',
            'dpd_active'    => 'active',
            'dpd_in'        => 'in',
            'dpd_produk'    => 'text-expat-green'
        );
        $this->load->view('layout/wrapper', $data);
    }

    public function addproduk_process()
    {
		$this->form_validation->set_rules('name', 'Name Produk', 'trim|max_length[255]|required');
		$this->form_validation->set_rules('description', 'Description', 'trim|required');
        $this->form_validation->set_rules('kategori', 'Kategori', 'trim|required');
		$this->form_validation->set_rules('favorite', 'Favorite', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', $this->message->error_msg(validation_errors()));
			redirect("produk/add_produk");
			return;
		}

        $input          = $this->input;
        $name           = $this->security->xss_clean($this->input->post("name"));
        $description    = $this->security->xss_clean($this->input->post("description"));
        $kategori       = $this->security->xss_clean($this->input->post("kategori"));
        $favorite       = $this->security->xss_clean($this->input->post("favorite"));

        $image      = $this->security->xss_clean($_FILES['imgproduk']);
        if(!empty($image['name'])){
            $blob       = curl_file_create($image['tmp_name'],$image['type']);
            $mdata = array(
                "nama"          => $name,
                "deskripsi"     => $description,
                "is_favorite"   => $favorite,
                "kategori"      => $kategori,
                "image"         => $blob
            );
        }else{

            $mdata = array(
                "nama"          => $name,
                "deskripsi"     => $description,
                "is_favorite"   => $favorite,
                "kategori"      => $kategori,
            );

        }


        $url = URLAPI . "/v1/produk/addProduk";
		$response = expatAPI($url, json_encode($mdata));
        $result = $response->result;


        if($response->status == 200) {
            $this->session->set_flashdata('success', $result->messages);
			redirect('produk');
			return;
        }else{
            $this->session->set_flashdata('error', $result->messages->error);
			redirect('produk/add_produk');
			return;
        }
    }

    public function edit_produk($id)
    {
        $id_produk	= base64_decode($this->security->xss_clean($id));

        $url = URLAPI . "/v1/produk/getproduk_byid?id=".$id_produk;
		$result = expatAPI($url)->result->messages;

        $data = array(
            'title'             => NAMETITLE . ' - Edit Produk',
            'content'           => 'admin/produk/edit_produk',
            'extra'             => 'admin/produk/js/_js_index',
            'produk'            => $result,
            'master_active'     => 'active',
            'master_in'         => 'in',
            'dpd_active'        => 'active',
            'dpd_in'            => 'in',
            'dpd_produk'        => 'text-expat-green'
        );

        $this->load->view('layout/wrapper', $data);
    }

    public function editproduk_process()
    {
		$this->form_validation->set_rules('name', 'Name Produk', 'trim|required|max_length[255]');
		$this->form_validation->set_rules('description', 'Description', 'trim|required');
		$this->form_validation->set_rules('kategori', 'Kategori', 'trim|required');
		$this->form_validation->set_rules('favorite', 'Favorite', 'trim|required');

        $input      = $this->input;
        $urisegment   = $this->security->xss_clean($input->post('urisegment'));

        if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error_validation', $this->message->error_msg(validation_errors()));
            redirect('produk/edit_produk/'.$urisegment);
			return;
		}

        $id             = base64_decode($urisegment);
        $name           = $this->security->xss_clean($this->input->post("name"));
        $description    = $this->security->xss_clean($this->input->post("description"));
        $kategori       = $this->security->xss_clean($this->input->post("kategori"));
        $favorite       = $this->security->xss_clean($this->input->post("favorite"));

        
        $image      = $this->security->xss_clean(@$_FILES['imgproduk']);

        if(!empty($image['name'])){
            $blob       = curl_file_create($image['tmp_name'],$image['type']);
            $mdata = array(
                "nama"          => $name,
                "deskripsi"     => $description,
                "kategori"      => $kategori,
                "is_favorite"   => $favorite,
                "image"         => $blob
            );
        }else{
            $mdata = array(
                "nama"          => $name,
                "deskripsi"     => $description,
                "kategori"      => $kategori,
                "is_favorite"   => $favorite,
            );

        }


        $url = URLAPI . "/v1/produk/updateProduk?id=".$id;
		$response = expatAPI($url, json_encode($mdata));
        $result = $response->result;

        if($response->status == 200){
            $this->session->set_flashdata('success', $result->messages);
			redirect('produk');
			return;
        }else{
            $this->session->set_flashdata('error', $result->messages->error);
            redirect('produk/edit_produk/'.$urisegment);
            return;
        }
    }

    public function delete($id)
    {
        $id_produk = base64_decode($this->security->xss_clean($id));

        $url = URLAPI . "/v1/produk/deleteProduk?id=".$id_produk;
		$response = expatAPI($url);
        $result = $response->result;
 

        if($response->status == 200){
            $this->session->set_flashdata('success', $result->messages);
        }else{
            $this->session->set_flashdata('error', $result->messages->error);
        }

        redirect('produk');
    }




    



    public function additional()
    {
        $data = array(
            'title'             => NAMETITLE . ' - Additional Produk',
            'content'           => 'admin/produk/additional/index',
            'extra'             => 'admin/produk/additional/js/_js_index',
            'master_active'     => 'active',
            'master_in'         => 'in',
            'dpd_active'        => 'active',
            'dpd_in'            => 'in',
            'dpd_additional'    => 'text-expat-green'
        );
        $this->load->view('layout/wrapper', $data);

    }

    public function list_alladditional()
    {
		$url = URLAPI . "/v1/additional/get_alladditional";
		$result = expatAPI($url)->result->messages;
        echo json_encode($result);  
        die;      
    }


    public function add_additional()
    {


        $url = URLAPI . "/v1/additional/get_groupadditional";
		$response = expatAPI($url);
        $result = $response->result->messages;
        
        $mdata = array(
            'title'             => NAMETITLE . ' - Add Additional Produk',
            'content'           => 'admin/produk/additional/add_additional',
            'extra'             => 'admin/produk/additional/js/_js_index',
            'group'             => $result,
            'master_active'     => 'active',
            'master_in'         => 'in',
            'dpd_active'        => 'active',
            'dpd_in'            => 'in',
            'dpd_additional'    => 'text-expat-green'
        );
        $this->load->view('layout/wrapper', $mdata);

    }

    public function addadditional_process()
    {
		$this->form_validation->set_rules('additional_group', 'Additional Group', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('additional', 'Additional Name', 'trim|required|max_length[100]');

        if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error_validation', $this->message->error_msg(validation_errors()));
			redirect("produk/add_additional");
			return;
		}

        $input              = $this->input;
        $additional         = $this->security->xss_clean($this->input->post("additional"));
        $additional_group   = $this->security->xss_clean($this->input->post("additional_group"));
        
        $mdata = array(
            "additional"        => $additional,
            "additional_group"  => $additional_group,
        );

        $url = URLAPI . "/v1/additional/addAdditional";
		$response = expatAPI($url, json_encode($mdata));
        $result = $response->result;


        if($response->status == 200) {
            $this->session->set_flashdata('success', $result->messages);
			redirect('produk/additional');
			return;
        }else{
            $this->session->set_flashdata('error', $result->messages->error);
			redirect('produk/add_additional');
			return;
        }
    }


    public function edit_additional($id)
    {
        $id_additional	= base64_decode($this->security->xss_clean($id));

        $url_detail = URLAPI . "/v1/additional/getadditional_byid?id=".$id_additional;
		$result_detail = expatAPI($url_detail)->result->messages;

        $url_group = URLAPI . "/v1/additional/get_groupadditional";
		$response_group = expatAPI($url_group);
        $result_group = $response_group->result->messages;

        $mdata = array(
            'title'             => NAMETITLE . ' - Edit Additional Produk',
            'content'           => 'admin/produk/additional/edit_additional',
            'extra'             => 'admin/produk/additional/js/_js_index',
            'group'             => $result_group,
            'detail'            => $result_detail,
            'master_active'     => 'active',
            'master_in'         => 'in',
            'dpd_active'        => 'active',
            'dpd_in'            => 'in',
            'dpd_additional'    => 'text-expat-green'
        );
        $this->load->view('layout/wrapper', $mdata);

    }

    public function editadditional_process()
    {
        $this->form_validation->set_rules('additional_group', 'Additional Group', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('additional', 'Additional Name', 'trim|required|max_length[100]');

        $input      = $this->input;
        $urisegment   = $this->security->xss_clean($input->post('urisegment'));

        if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error_validation', $this->message->error_msg(validation_errors()));
			redirect("produk/edit_additional/".$urisegment);
			return;
		}

        $id                 = base64_decode($urisegment);
        $additional         = $this->security->xss_clean($this->input->post("additional"));
        $additional_group   = $this->security->xss_clean($this->input->post("additional_group"));
        
        $mdata = array(
            "additional"        => $additional,
            "additional_group"  => $additional_group,
        );

        $url = URLAPI . "/v1/additional/updateAdditional?id=".$id;
		$response = expatAPI($url, json_encode($mdata));
        $result = $response->result;


        if($response->status == 200) {
            $this->session->set_flashdata('success', $result->messages);
			redirect('produk/additional');
			return;
        }else{
            $this->session->set_flashdata('error', $result->messages->error);
			redirect("produk/edit_additional/".$urisegment);
			return;
        }
    }

    public function delete_additional($id)
    {
        $id_additional = base64_decode($this->security->xss_clean($id));

        $url = URLAPI . "/v1/additional/deleteAdditional?id=".$id_additional;
		$response = expatAPI($url);
        $result = $response->result;


        if($response->status == 200){
            $this->session->set_flashdata('success', $result->messages);
        }else{
            $this->session->set_flashdata('error', $result->messages->error);
        }

        redirect('produk/additional');
    }



    
    public function optional()
    {
        $data = array(
            'title'             => NAMETITLE . ' - Optional Produk',
            'content'           => 'admin/produk/optional/index',
            'extra'             => 'admin/produk/optional/js/_js_index',
            'master_active'     => 'active',
            'master_in'         => 'in',
            'dpd_active'        => 'active',
            'dpd_in'            => 'in',
            'dpd_optional'      => 'text-expat-green'
        );
        $this->load->view('layout/wrapper', $data);

    }

    public function list_alloptional()
    {
		$url = URLAPI . "/v1/optional/get_alloptional";
		$result = expatAPI($url)->result->messages;
        echo json_encode($result);  
        die;      
    }


    public function add_optional()
    {


        $url = URLAPI . "/v1/optional/get_groupoptional";
		$response = expatAPI($url);
        $result = $response->result->messages;
        
        $mdata = array(
            'title'             => NAMETITLE . ' - Add Optional Produk',
            'content'           => 'admin/produk/optional/add_optional',
            'extra'             => 'admin/produk/optional/js/_js_index',
            'group'             => $result,
            'master_active'     => 'active',
            'master_in'         => 'in',
            'dpd_active'        => 'active',
            'dpd_in'            => 'in',
            'dpd_optional'    => 'text-expat-green'
        );
        $this->load->view('layout/wrapper', $mdata);

    }

    public function addoptional_process()
    {
		$this->form_validation->set_rules('optional_group', 'Optional Group', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('optional', 'Optional Name', 'trim|required|max_length[100]');

        if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error_validation', $this->message->error_msg(validation_errors()));
			redirect("produk/add_optional");
			return;
		}

        $input              = $this->input;
        $optional         = $this->security->xss_clean($this->input->post("optional"));
        $optional_group   = $this->security->xss_clean($this->input->post("optional_group"));
        
        $mdata = array(
            "optional"        => $optional,
            "optiongroup"     => $optional_group,
        );

        $url = URLAPI . "/v1/optional/addoptional";
		$response = expatAPI($url, json_encode($mdata));
        $result = $response->result;

        if($response->status == 200) {
            $this->session->set_flashdata('success', $result->messages);
			redirect('produk/optional');
			return;
        }else{
            $this->session->set_flashdata('error', $result->messages->error);
			redirect('produk/add_optional');
			return;
        }
    }

    public function edit_optional($id)
    {
        $id_optional	= base64_decode($this->security->xss_clean($id));

        $url_detail = URLAPI . "/v1/optional/getoptional_byid?id=".$id_optional;
		$result_detail = expatAPI($url_detail)->result->messages;

        $url_group = URLAPI . "/v1/optional/get_groupoptional";
		$response_group = expatAPI($url_group);
        $result_group = $response_group->result->messages;

        $mdata = array(
            'title'             => NAMETITLE . ' - Edit optional Produk',
            'content'           => 'admin/produk/optional/edit_optional',
            'extra'             => 'admin/produk/optional/js/_js_index',
            'group'             => $result_group,
            'detail'            => $result_detail,
            'master_active'     => 'active',
            'master_in'         => 'in',
            'dpd_active'        => 'active',
            'dpd_in'            => 'in',
            'dpd_optional'    => 'text-expat-green'
        );
        $this->load->view('layout/wrapper', $mdata);

    }

    public function editoptional_process()
    {
        $this->form_validation->set_rules('optional_group', 'optional Group', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('optional', 'optional Name', 'trim|required|max_length[100]');

        $input      = $this->input;
        $urisegment   = $this->security->xss_clean($input->post('urisegment'));

        if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error_validation', $this->message->error_msg(validation_errors()));
			redirect("produk/edit_optional/".$urisegment);
			return;
		}

        $id                 = base64_decode($urisegment);
        $optional         = $this->security->xss_clean($this->input->post("optional"));
        $optional_group   = $this->security->xss_clean($this->input->post("optional_group"));
        
        $mdata = array(
            "optional"      => $optional,
            "optiongroup"   => $optional_group,
        );

        $url = URLAPI . "/v1/optional/updateOptional?id=".$id;
		$response = expatAPI($url, json_encode($mdata));
        $result = $response->result;


        if($response->status == 200) {
            $this->session->set_flashdata('success', $result->messages);
			redirect('produk/optional');
			return;
        }else{
            $this->session->set_flashdata('error', $result->messages->error);
			redirect("produk/edit_optional/".$urisegment);
			return;
        }
    }

    public function delete_optional($id)
    {
        $id_optional = base64_decode($this->security->xss_clean($id));

        $url = URLAPI . "/v1/optional/deleteOptional?id=".$id_optional;
		$response = expatAPI($url);
        $result = $response->result;


        if($response->status == 200){
            $this->session->set_flashdata('success', $result->messages);
        }else{
            $this->session->set_flashdata('error', $result->messages->error);
        }

        redirect('produk/optional');
    }

    
    
    
    
    
    public function satuan()
    {
        $data = array(
            'title'             => NAMETITLE . ' - Satuan Produk',
            'content'           => 'admin/produk/satuan/index',
            'extra'             => 'admin/produk/satuan/js/_js_index',
            'master_active'     => 'active',
            'master_in'         => 'in',
            'dpd_active'        => 'active',
            'dpd_in'            => 'in',
            'dpd_satuan'        => 'text-expat-green'
        );
        $this->load->view('layout/wrapper', $data);

    }
    

    public function list_allsatuan()
    {
		$url = URLAPI . "/v1/satuan/get_allsatuan";
		$result = expatAPI($url)->result->messages;
        echo json_encode($result);  
        die;      
    }


    public function add_satuan()
    {


        $url = URLAPI . "/v1/satuan/get_groupsatuan";
		$response = expatAPI($url);
        $result = $response->result->messages;
        
        $mdata = array(
            'title'             => NAMETITLE . ' - Add satuan Produk',
            'content'           => 'admin/produk/satuan/add_satuan',
            'extra'             => 'admin/produk/satuan/js/_js_index',
            'group'             => $result,
            'master_active'     => 'active',
            'master_in'         => 'in',
            'dpd_active'        => 'active',
            'dpd_in'            => 'in',
            'dpd_satuan'    => 'text-expat-green'
        );
        $this->load->view('layout/wrapper', $mdata);

    }

    public function addsatuan_process()
    {
		$this->form_validation->set_rules('satuan_group', 'satuan Group', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('satuan', 'satuan Name', 'trim|required|max_length[100]');

        if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error_validation', $this->message->error_msg(validation_errors()));
			redirect("produk/add_satuan");
			return;
		}

        $input              = $this->input;
        $satuan         = $this->security->xss_clean($this->input->post("satuan"));
        $satuan_group   = $this->security->xss_clean($this->input->post("satuan_group"));
        
        $mdata = array(
            "satuan"        => $satuan,
            "groupname"     => $satuan_group,
        );

        $url = URLAPI . "/v1/satuan/addsatuan";
		$response = expatAPI($url, json_encode($mdata));
        $result = $response->result;

        if($response->status == 200) {
            $this->session->set_flashdata('success', $result->messages);
			redirect('produk/satuan');
			return;
        }else{
            $this->session->set_flashdata('error', $result->messages->error);
			redirect('produk/add_satuan');
			return;
        }
    }
    

    public function edit_satuan($id)
    {
        $id_satuan	= base64_decode($this->security->xss_clean($id));

        $url_detail = URLAPI . "/v1/satuan/getsatuan_byid?id=".$id_satuan;
		$result_detail = expatAPI($url_detail)->result->messages;

        $url_group = URLAPI . "/v1/satuan/get_groupsatuan";
		$response_group = expatAPI($url_group);
        $result_group = $response_group->result->messages;

        $mdata = array(
            'title'             => NAMETITLE . ' - Edit satuan Produk',
            'content'           => 'admin/produk/satuan/edit_satuan',
            'extra'             => 'admin/produk/satuan/js/_js_index',
            'group'             => $result_group,
            'detail'            => $result_detail,
            'master_active'     => 'active',
            'master_in'         => 'in',
            'dpd_active'        => 'active',
            'dpd_in'            => 'in',
            'dpd_satuan'    => 'text-expat-green'
        );
        $this->load->view('layout/wrapper', $mdata);

    }

    public function editsatuan_process()
    {
        $this->form_validation->set_rules('satuan_group', 'satuan Group', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('satuan', 'satuan Name', 'trim|required|max_length[100]');

        $input      = $this->input;
        $urisegment   = $this->security->xss_clean($input->post('urisegment'));

        if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error_validation', $this->message->error_msg(validation_errors()));
			redirect("produk/edit_satuan/".$urisegment);
			return;
		}

        $id                 = base64_decode($urisegment);
        $satuan         = $this->security->xss_clean($this->input->post("satuan"));
        $satuan_group   = $this->security->xss_clean($this->input->post("satuan_group"));
        
        $mdata = array(
            "satuan"      => $satuan,
            "groupname"   => $satuan_group,
        );

        $url = URLAPI . "/v1/satuan/updatesatuan?id=".$id;
		$response = expatAPI($url, json_encode($mdata));
        $result = $response->result;


        if($response->status == 200) {
            $this->session->set_flashdata('success', $result->messages);
			redirect('produk/satuan');
			return;
        }else{
            $this->session->set_flashdata('error', $result->messages->error);
			redirect("produk/edit_satuan/".$urisegment);
			return;
        }
    }

    public function delete_satuan($id)
    {
        $id_satuan = base64_decode($this->security->xss_clean($id));

        $url = URLAPI . "/v1/satuan/deletesatuan?id=".$id_satuan;
		$response = expatAPI($url);
        $result = $response->result;


        if($response->status == 200){
            $this->session->set_flashdata('success', $result->messages);
        }else{
            $this->session->set_flashdata('error', $result->messages->error);
        }

        redirect('produk/satuan');
    }
    
    
    public function variant()
    {

        $url_produk = URLAPI . "/v1/produk/get_allproduk";
		$response_produk = expatAPI($url_produk);
        $result_produk = $response_produk->result->messages;


        $data = array(
            'title'             => NAMETITLE . ' - Variant Produk',
            'content'           => 'admin/produk/variant/index',
            'extra'             => 'admin/produk/variant/js/_js_index',
            'produk'            => $result_produk,
            'master_active'     => 'active',
            'master_in'         => 'in',
            'dpd_active'        => 'active',
            'dpd_in'            => 'in',
            'dpd_variant'       => 'text-expat-green'
        );
        $this->load->view('layout/wrapper', $data);

    }

    public function list_variant_produk()
    {
        $id_produk	= $this->security->xss_clean($this->input->post('id_produk'));

		$url = URLAPI . "/v1/produk/get_varianbyid?id=".$id_produk;
		$result = expatAPI($url)->result->messages;
        echo json_encode($result);  
    }

    
    public function add_variant()
    {

		$result_allproduk   = expatAPI(URLAPI . "/v1/produk/get_allproduk")->result->messages;
		$result_cabang      = expatAPI(URLAPI . "/v1/outlet/get_allcabang")->result->messages;
		$result_optional    = expatAPI(URLAPI . "/v1/optional/get_groupoptional")->result->messages;
		$result_additional  = expatAPI(URLAPI . "/v1/additional/get_groupadditional")->result->messages;
		$result_satuan      = expatAPI(URLAPI . "/v1/satuan/get_groupsatuan")->result->messages;


        $mdata = array(
            'title'             => NAMETITLE . ' - Add Variant Produk',
            'content'           => 'admin/produk/variant/add_variant',
            'extra'             => 'admin/produk/variant/js/_js_index',
            'allproduk'         => $result_allproduk,
            'cabang'            => $result_cabang,
            'optional'          => $result_optional,
            'additional'        => $result_additional,
            'satuan'            => $result_satuan,
            'master_active'     => 'active',
            'master_in'         => 'in',
            'dpd_active'        => 'active',
            'dpd_in'            => 'in',
            'dpd_variant'       => 'text-expat-green'
        );
        $this->load->view('layout/wrapper', $mdata);

    }

    public function variant_additional(){
        $url = URLAPI . "/v1/additional/get_alladditional";
		$response = expatAPI($url);
        $result = $response->result->messages;
        echo json_encode($result);
    }
    
    public function variant_optional(){
        $url = URLAPI . "/v1/optional/get_alloptional";
		$response = expatAPI($url);
        $result = $response->result->messages;
        echo json_encode($result);
    }
    
    public function variant_satuan(){
        $url = URLAPI . "/v1/satuan/get_allsatuan";
		$response = expatAPI($url);
        $result = $response->result->messages;
        echo json_encode($result);
    }

    public function addvariant_process()
    {
		$this->form_validation->set_rules('produk', 'Produk', 'trim|required');
		$this->form_validation->set_rules('additional[]', 'Additional', 'trim');
		$this->form_validation->set_rules('optional[]', 'Optional', 'trim');
		$this->form_validation->set_rules('satuan[]', 'Satuan', 'trim|required');
		$this->form_validation->set_rules('cabang[]', 'Cabang', 'trim|required');
		$this->form_validation->set_rules('harga', 'Harga', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', $this->message->error_msg(validation_errors()));
			redirect("produk/add_variant");
			return;
		}

        $input          = $this->input;
        $produk         = $this->security->xss_clean($this->input->post("produk"));
        $additional     = $this->security->xss_clean($this->input->post("additional"));
        $optional       = $this->security->xss_clean($this->input->post("optional"));
        $satuan         = $this->security->xss_clean($this->input->post("satuan"));
        $cabang         = $this->security->xss_clean($this->input->post("cabang"));
        $harga         = $this->security->xss_clean($this->input->post("harga"));
        
        $mdata = array(
            "additional"    => (empty($additional) ? array() : $additional),
            "optional"      => (empty($optional) ? array() : $optional),
            "satuan"        => (empty($satuan) ? array() : $satuan),
            "cabang"        => $cabang,
            "harga"         => str_replace(",", "", $harga),
        );

        // echo '<pre>'.print_r($mdata,true).'</pre>';
        
        $url = URLAPI . "/v1/produk/addvarian?id=".$produk;
		$response = expatAPI($url, json_encode($mdata));
        $result = $response->result;
        // echo '<pre>'.print_r($response,true).'</pre>';
        // die;
        if($response->status == 200) {
            $this->session->set_flashdata('success', $result->messages);
			redirect('produk/variant');
			return;
        }else{
            $this->session->set_flashdata('error', $result->messages->error);
			redirect('produk/add_variant');
			return;
        }
    }

    public function edit_variant($id=null)
    {

        if($id != null){
            $id_variant	= base64_decode($this->security->xss_clean($id));
            $result   = expatAPI(URLAPI . "/v1/produk/get_detailbyid?id=".$id_variant)->result->messages;
        }


        $mdata = array(
            'title'             => NAMETITLE . ' - Add Variant Produk',
            'content'           => 'admin/produk/variant/edit_variant',
            'extra'             => 'admin/produk/variant/js/_js_index',
            'variant'           => @$result,
            'master_active'     => 'active',
            'master_in'         => 'in',
            'dpd_active'        => 'active',
            'dpd_in'            => 'in',
            'dpd_variant'       => 'text-expat-green'
        );
        $this->load->view('layout/wrapper', $mdata);

    }

    public function editvariant_process()
    {
        $this->form_validation->set_rules('newharga', 'New Harga', 'trim|required');

        $input      = $this->input;
        
        $idproduk    = $this->security->xss_clean($input->post('idproduk'));
        $urisegment   = $this->security->xss_clean($input->post('urisegment'));


        if(empty($idproduk)){
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error_validation', $this->message->error_msg(validation_errors()));
                redirect("produk/edit_variant/".$urisegment);
                return;
            }
        }else{
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error_validation', $this->message->error_msg(validation_errors()));
                redirect("produk/edit_variant?produk=".$idproduk);
                return;
            }
        }

        $id             = base64_decode($urisegment);
        $newharga       = str_replace(",", "", $this->security->xss_clean($this->input->post("newharga")));
        

        if(empty($idproduk)){
            $url = URLAPI . "/v1/produk/updateVarian?id=". $id ."&harga=". $newharga;
        }else{
            $url = URLAPI . "/v1/produk/updateVarian_byproduk?id=". $idproduk ."&harga=". $newharga;
        }
        
		$response = expatAPI($url);
        $result = $response->result;
        
        if($response->status == 200) {
            $this->session->set_flashdata('success', $result->messages);
			redirect('produk/variant');
			return;
        }else{
            $this->session->set_flashdata('error', $result->messages->error);
			redirect("produk/edit_variant/".$urisegment);
			return;
        }
    }

    public function delete_variant($id)
    {
        $id_variant = base64_decode($this->security->xss_clean($id));

        $url = URLAPI . "/v1/produk/deleteVarian?id=".$id_variant;
		$response = expatAPI($url);
        $result = $response->result;


        if($response->status == 200){
            $this->session->set_flashdata('success', $result->messages);
        }else{
            $this->session->set_flashdata('error', $result->messages->error);
        }

        redirect('produk/variant');
    }
    
    


}