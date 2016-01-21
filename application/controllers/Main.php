<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
    
    public function __construct() {
	parent::__construct();
	$this->load->helper('url');
	$this->load->model('main_model');
    }
    
    public function index(){
	$this->load->view("public/head",array("title"=>"Главная"));
	$this->load->view("public/menu",array("str"=>uri_string()));
	$this->load->view("main/index");
	$this->load->view("public/footer",array(
		"css"=>array(
		),
		"load_js"=>array(
		)
	    )
	);
    }

    
}
