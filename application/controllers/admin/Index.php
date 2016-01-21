<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 *Входной файл для админки, тут навигация по админки 
 *  
 */

class Index extends CI_Controller {

    public function __construct() {
	parent::__construct();
	$this->load->helper('url');
	$this->load->library(array('ion_auth','form_validation','pagination'));
	//$this->load->model(array('admin_model','select_db'));
	if (!$this->ion_auth->logged_in()){
	    redirect('auth', 'refresh');
	}elseif (!$this->ion_auth->is_admin()){
	    return show_error('You must be an administrator to view this page.');
	}
	$this->load->model(array('admin/index_model'));
    }
    
    /*
     * 
     * Входной метод 
     * return	countCategory - количество страниц по каждой категории
     *		countPages - общее количество страниц в бд
     *		countCategoryProducts - количество  товаров по каждой категории
     *		countProducts - общее количество страниц в бд
     *		countFilesType - количество файлов  по каждой категории
     *		countFiles - общее количество файлов
     */
    public function index() {
	$this->load->view("admin/public/head");
	$this->load->view("admin/public/side-bar");
	$this->load->view("admin/index/index",array(
	    "countPages"=>$this->index_model->countPages()->result()[0],
	    "countCategory"=>$this->index_model->countCategory(),
	    "countProducts"=>$this->index_model->countProducts()->result()[0],
	    "countCategoryProducts"=>$this->index_model->countCategoryProducts(),
	    "countFiles"=>$this->index_model->countFiles()->result()[0],
	    "countFilesType"=>$this->index_model->countFilesType()
	));
    }
    
}