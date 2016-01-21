<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Files_model extends CI_Model{
    
    public $config_img=array(
	'upload_path'=>'./uploads/images/',
	'allowed_types'=>'png|jpg|jpeg',
	'max_size'=>'250',
	'max_width'=>'1024',
	'max_height'=>'768'
    );
    
    public $config_doc=array(
	'upload_path'=>'./uploads/docs/',
	'allowed_types'=>'doc|docx|pdf|xls',
	'max_size'=>'2048',
    );

    public function __construct() {
	parent::__construct();
	$this->load->database();
	$this->load->library(array('ion_auth','form_validation'));
	if (!$this->ion_auth->logged_in()){
	    redirect('auth', 'refresh');
	}elseif (!$this->ion_auth->is_admin()){
	    return show_error('You must be an administrator to view this page.');
	}
    }
    
    //удалим запись из бд
    public function delete($id) {
	$file=$this->db->query("SELECT * FROM `files` WHERE `id`=".(int)$id)->result()[0];
	switch($file->type){
	    case "img":
		$way = "/images/".$file->name;
		break;
	    case "doc":
		$way = "/docs/".$file->name;
		break;
	}
	unlink("./uploads".$way);
	$this->db->query("UPDATE `pages` SET `photo`=0 WHERE `photo`=".(int)$id);
	$this->db->query("UPDATE `products` SET `photo`=0 WHERE `photo`=".(int)$id);
	$this->db->query("DELETE FROM `page_file` WHERE `file_id`=".(int)$id);
	$this->db->query("DELETE FROM `product_file` WHERE `file_id`=".(int)$id);
	return $this->db->query("DELETE FROM `files` WHERE `id`=".(int)$id);
    }

    //добавляем запись в бд
    public function insert($name,$type) {
	foreach($name as $row){
	    $this->db->query("INSERT INTO `files` (name,type) VALUES(?,?)",array($row,$type));
	}
    }

    //выборка записей
    public function files( $limit=0) {
	return $this->db->query("SELECT `files`.* from `files` "
		. "ORDER BY id DESC LIMIT ".$limit.",10");
    }
    
    //получим статистику по количеству страниц в бд для pagination
    public function pagination(){
	return $this->db->query("SELECT count(*) as count FROM `files`");
    }
    
}