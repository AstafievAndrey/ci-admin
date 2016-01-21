<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends CI_Controller {

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
	$this->load->model(array("admin/categories_model"));
    }

    public function index($limit=0) {
	$this->load->library('pagination');
	$categ = $this->categories_model->getCategories($limit);
	$config = array(
	    'base_url'=>base_url()."admin/categories/",
	    'total_rows'=>(int)$categ["count"]->result()[0]->count,
	    "first_link"=>false,"last_link"=>false,
	    "per_page"=>10
	);
	$this->pagination->initialize($config);
	$this->load->view("admin/public/head");
	$this->load->view("admin/public/side-bar");
	$this->load->view("admin/categories/index",array(
			"pag"=>$this->pagination->create_links(),
			"categories"=>$categ["categ"]
		    )
		);
    }
    
    public function delete($id=NULL){
	if(is_null($id)){redirect(base_url()."admin/categories");}
	if(is_null($this->input->post("delete"))){
	    $this->load->view("admin/public/head");
	    $this->load->view("admin/public/side-bar");
	    $this->load->view("admin/categories/delete",array(
		    "id"=>$id,
		    "category"=>$this->categories_model->getCategory((int)$id)->result()[0]
		));
	}else{
	    if((int)$this->input->post("delete")==1){
		$this->categories_model->delete((int)$this->input->post("id"));
	    }
	    redirect($this->input->post("redirect"));
	}
    }
    
    public function edit($id=NULL) {
	if (is_null($id)) {redirect(base_url()."admin/categories");}
	$this->load->view("admin/public/head");
	$this->load->view("admin/public/side-bar");
	$this->load->view("admin/categories/edit",array(
	    "category"=>$this->categories_model->getCategory($id)->result()[0]
	));
    }
    
    public function add() {
	$this->load->view("admin/public/head");
	$this->load->view("admin/public/side-bar");
	$this->load->view("admin/categories/add");
    }
    
     public function form_valid_edit(){
	$this->load->helper('form');
	$this->load->library('form_validation');
	($this->input->post("old_translit")==$this->input->post("translit"))
	    ?$this->form_validation->set_rules($this->categories_model->config_validation_edit)
	    :$this->form_validation->set_rules($this->categories_model->config_validation_add);
	if ($this->form_validation->run() == FALSE){
	    echo validation_errors();
	}else{
	    if(validation_errors()==""){
		redirect(base_url()."admin/categories/edit/".$this->categories_model->update());
	    }else{
		echo validation_errors();
	    }
	} 
    }
    
    public function form_valid_add(){
	$this->load->helper('form');
	$this->load->library('form_validation');
	$this->form_validation->set_rules($this->categories_model->config_validation_add);
	if ($this->form_validation->run() == FALSE){
	    echo validation_errors();
	}else{
	    if(validation_errors()==""){
		$this->categories_model->insert();
		redirect(base_url()."admin/categories/add");
	    }else{
		echo validation_errors();
	    }
	}
    }
    
}