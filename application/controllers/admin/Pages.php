<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

    public function __construct() {
	parent::__construct();
	$this->load->helper('url');
	$this->load->library(array('ion_auth'));
	//$this->load->model(array('admin_model','select_db'));
	if (!$this->ion_auth->logged_in()){
	    redirect('auth', 'refresh');
	}elseif (!$this->ion_auth->is_admin()){
	    return show_error('You must be an administrator to view this page.');
	}
	$this->load->model(array("admin/pages_model"));
    }
    
    public function delete($id=NULL){
	if(is_null($id)){redirect(base_url()."admin/pages");}
	if(is_null($this->input->post("delete"))){
	    $this->load->view("admin/public/head");
	    $this->load->view("admin/public/side-bar");
	    $this->load->view("admin/pages/delete",array(
		    "id"=>$id,
		    "page"=>$this->pages_model->getPage((int)$id)->result()[0]
		));
	}else{
	    if((int)$this->input->post("delete")==1){
		$this->pages_model->delete((int)$this->input->post("id"));
	    }
	    redirect($this->input->post("redirect"));
	}
    }

    public function index($limit=0) {
	$this->load->library('pagination');
	$config = array(
	    'base_url'=>base_url()."admin/pages/",
	    'total_rows'=>(int)$this->pages_model->pagination()->result()[0]->count,
	    "first_link"=>false,"last_link"=>false,
	    "per_page"=>10
	);
	$this->pagination->initialize($config);
	$this->load->view("admin/public/head");
	$this->load->view("admin/public/side-bar");
	$this->load->view("admin/pages/index",array(
			"pag"=>$this->pagination->create_links(),
			"pages"=>$this->pages_model->pages($limit)
		    )
		);
    }
    
    public function edit($id=NULL) {
	if(is_null($id)){redirect(base_url()."admin/pages");}
	$this->load->view("admin/public/head");
	$this->load->view("admin/public/side-bar");
	$this->load->view("admin/pages/edit",array(
		"categ"=>$this->pages_model->category(),
		"page"=>$this->pages_model->getPage((int)$id)->result()[0],
		"categ"=>$this->pages_model->category(),
		"img"=>$this->pages_model->get_images(),
		"attach_img"=>$this->pages_model->page_file($id)
	    ));
    }
    
    public function delete_page_file(){
	if(!is_null($this->input->post("id"))){
	    echo $this->pages_model->delete_page_file($this->input->post("id"));
	}else{
	    echo 0;
	}
    }


    public function add() {
	$this->load->view("admin/public/head");
	$this->load->view("admin/public/side-bar");
	$this->load->view("admin/pages/add",array(
		"categ"=>$this->pages_model->category(),
		"img"=>$this->pages_model->get_images()
	    ));
    }
    
    public function form_valid_edit(){
	if(!is_null($this->input->post("imgs"))){
	    $this->pages_model->edit_insert_image();
	}
	$this->load->helper('form');
	$this->load->library('form_validation');
	($this->input->post("old_translit")==$this->input->post("translit"))
	    ?$this->form_validation->set_rules($this->pages_model->config_validation_edit)
	    :$this->form_validation->set_rules($this->pages_model->config_validation_add);
	if ($this->form_validation->run() == FALSE){
	    echo validation_errors();
	}else{
	    if(validation_errors()==""){
		redirect(base_url()."admin/pages/edit/".$this->pages_model->update());
	    }else{
		echo validation_errors();
	    }
	}
    }
    
    public function form_valid_add(){
	$imgs=$this->input->post("imgs");
	unset($_POST["imgs"]);
	$this->load->helper('form');
	$this->load->library('form_validation');
	$this->form_validation->set_rules($this->pages_model->config_validation_add);
	if ($this->form_validation->run() == FALSE){
	    echo validation_errors();
	}else{
	    if(validation_errors()==""){
		if((int)$this->pages_model->insert()==1){
		    if(!is_null($imgs)){
			$this->pages_model->insert_images($imgs);
		    }
		    redirect(base_url()."admin/pages/add");
		}
	    }else{
		echo validation_errors();
	    }
	}
    }
    
}