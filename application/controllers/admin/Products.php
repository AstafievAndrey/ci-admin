<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

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
	$this->load->model(array("admin/products_model"));
    }
    
    public function delete($id=NULL){
	if(is_null($id)){redirect(base_url()."admin/products");}
	if(is_null($this->input->post("delete"))){
	    $this->load->view("admin/public/head");
	    $this->load->view("admin/public/side-bar");
	    $this->load->view("admin/products/delete",array(
		    "id"=>$id,
		    "product"=>$this->products_model->getProduct((int)$id)->result()[0]
		));
	}else{
	    if((int)$this->input->post("delete")==1){
		$this->products_model->delete((int)$this->input->post("id"));
	    }
	    redirect($this->input->post("redirect"));
	}
    }

    public function index($limit=0) {
	$this->load->library('pagination');
	$config = array(
	    'base_url'=>base_url()."admin/products/",
	    'total_rows'=>(int)$this->products_model->pagination()->result()[0]->count,
	    "first_link"=>false,"last_link"=>false,
	    "per_page"=>10
	);
	$this->pagination->initialize($config);
	$this->load->view("admin/public/head");
	$this->load->view("admin/public/side-bar");
	$this->load->view("admin/products/index",array(
			"pag"=>$this->pagination->create_links(),
			"products"=>$this->products_model->products($limit)
		    )
		);
    }
    
    public function add() {
	$this->load->view("admin/public/head");
	$this->load->view("admin/public/side-bar");
	$this->load->view("admin/products/add",array(
		"categ"=>$this->products_model->category(),
		"img"=>$this->products_model->get_images()
	    ));
    }
    
    public function edit($id=NULL) {
	if(is_null($id)){redirect(base_url()."admin/products");}
	$this->load->view("admin/public/head");
	$this->load->view("admin/public/side-bar");
	$this->load->view("admin/products/edit",array(
		"categ"=>$this->products_model->category(),
		"product"=>$this->products_model->getProduct((int)$id)->result()[0],
		"img"=>$this->products_model->get_images(),
		"attach_img"=>$this->products_model->product_file((int)$id)
	    ));
    }
    
    
    public function delete_product_file(){
	if(!is_null($this->input->post("id"))){
	    echo $this->products_model->delete_product_file($this->input->post("id"));
	}else{
	    echo 0;
	}
    }
    
    public function form_valid_edit(){
	if(!is_null($this->input->post("imgs"))){
	    $this->products_model->edit_insert_image();
	}
	$this->load->helper('form');
	$this->load->library('form_validation');
	($this->input->post("old_translit")==$this->input->post("translit"))
	    ?$this->form_validation->set_rules($this->products_model->config_validation_edit)
	    :$this->form_validation->set_rules($this->products_model->config_validation_add);
	if ($this->form_validation->run() == FALSE){
	    echo validation_errors();
	}else{
	    if(validation_errors()==""){
		redirect(base_url()."admin/products/edit/".$this->products_model->update());
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
	$this->form_validation->set_rules($this->products_model->config_validation_add);
	if ($this->form_validation->run() == FALSE){
	    echo validation_errors();
	}else{
	    if(validation_errors()==""){
		if((int)$this->products_model->insert()==1){
		    if(!is_null($imgs)){
			$this->products_model->insert_images($imgs);
		    }
		    redirect(base_url()."admin/products/add");
		}
	    }else{
		echo validation_errors();
	    }
	}
    }
    
    
}