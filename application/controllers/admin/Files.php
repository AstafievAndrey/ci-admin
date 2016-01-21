<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 *Загрузка/удаление файлов
 *  
 */

class Files extends CI_Controller {
    
    public function __construct() {
	parent::__construct();
	$this->load->helper('url');
	$this->load->library(array('ion_auth'));
	if (!$this->ion_auth->logged_in()){
	    redirect('auth', 'refresh');
	}elseif (!$this->ion_auth->is_admin()){
	    return show_error('You must be an administrator to view this page.');
	}
	$this->load->model(array("admin/files_model"));
    }
    
    public function index($limit=0){
	$this->load->library('pagination');
	$config = array(
	    'base_url'=>base_url()."admin/files/",
	    'total_rows'=>(int)$this->files_model->pagination()->result()[0]->count,
	    "first_link"=>false,"last_link"=>false,
	    "per_page"=>10
	);
	$this->pagination->initialize($config);
	$this->load->view("admin/public/head");
	$this->load->view("admin/public/side-bar");
	$this->load->view("admin/files/index",array(
			"pag"=>$this->pagination->create_links(),
			"files"=>$this->files_model->files($limit)
		    )
		);
    }
    
    
    public function delete($id=NULL) {
	if(is_null($id)){redirect(base_url()."admin/pages");}
	if(is_null($this->input->post("delete"))){
	    $this->load->view("admin/public/head");
	    $this->load->view("admin/public/side-bar");
	    $this->load->view("admin/files/delete",array(
		    "id"=>$id
		));
	}else{
	    if((int)$this->input->post("delete")==1){
		$this->files_model->delete((int)$this->input->post("id"));
	    }
	    redirect($this->input->post("redirect"));
	}
    }
    
    //форма для загрузки файлов
    public function download() {
	$this->load->view("admin/public/head");
	$this->load->view("admin/public/side-bar");
	$this->load->view("admin/files/download");
    }
    
    public function download_upl() {
	$error=[];$upload_data=[];
	switch($this->input->post("type")){
	    case "img":
		    $this->load->library('upload', $this->files_model->config_img);
		break;
	    case "doc":
		    $this->load->library('upload', $this->files_model->config_doc);
		break;
	}
	for($i=0;$i<count($_FILES["files"]["name"]);$i++){
	    $_FILES["image"]=array("name"=>$_FILES["files"]["name"][$i],"type"=>$_FILES["files"]["type"][$i],"tmp_name"=>$_FILES["files"]["tmp_name"][$i],"error"=>$_FILES["files"]["error"][$i],"size"=>$_FILES["files"]["size"][$i]);
	    if (! $this->upload->do_upload("image")){array_push($error,$this->upload->display_errors());
	    }else{array_push($upload_data, $this->upload->data()["file_name"]);}
	}
	$this->files_model->insert($upload_data,$this->input->post("type"));
	if(count($error)==0){
	    redirect(base_url()."/admin/files/download");
	}else{
	    echo "<a href='".base_url()."/admin/files/download"."'>Вернуться обратно</a>";
	    echo "<br><pre>";
	    var_dump($error);
	    echo "</pre>";
	}
    }
    
    
    
}