<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Main_model extends CI_Model{
    
    public function __construct() {
	parent::__construct();
	$this->load->database();
    }
    
    //получим статью
    public function getArticle($translit) {
	return 
	$this->db->query("SELECT `pages`.*, `files`.`name` as `name_img` FROM `pages`,`files` WHERE `pages`.`translit`=? and `pages`.`photo` = `files`.`id`",array($translit));
    }
    
    //получим оследние три статьи
    public function getLastArticles() {
	return $this->db->query("SELECT `pages`.*, `files`.`name` as `name_img` FROM `pages`,`files` WHERE `pages`.`photo`!=0 and `pages`.`photo` = `files`.`id` ORDER BY `pages`.`id`  DESC LIMIT 0,3");
    }
    
    //Получим статьи
    public function getArticles($limit=0) {
	return array(
	    "count"=>$this->db->query("SELECT count(*) as count FROM `pages` WHERE `pages`.`category_id`=1"),
	    "articles"=>$this->db->query("SELECT `pages`.*, `files`.`name` as `name_img` FROM `pages`,`files` WHERE `pages`.`category_id`=1 and `pages`.`photo` = `files`.`id`  LIMIT $limit,10")
	);
	
    }
    
    //получим все диваны связанные с нужной категорией
    public function cetegDivan($categ=2,$limit=0) {
	return array(
	    "count"=>$this->db->query("SELECT count(*) as count FROM `products` WHERE `category_id`=?",array((int)$categ)),
	    "divany"=>$this->db->query("SELECT `products`.*, `files`.`name` as `img` FROM `products` JOIN `files` ON `files`.`id`=`products`.`photo`  WHERE `category_id`=".(int)$categ." ORDER BY `id` DESC LIMIT ".(int)$limit.",9")
	);
    }
    
    //получим информацию про диван
    public function getDivan($translit) {
	return $this->db->query("SELECT `products`.*, `files`.`name` as `name_img` FROM `products`,`files` WHERE `products`.`photo`=`files`.`id` and  `products`.`translit`=?",array($translit));
    }
    
    //получим соседей
    public function getNeighbors($id,$categ) {
	return array(
	    "back"=>$this->db->query("SELECT * FROM `products` WHERE `id`<? and `category_id`=? ORDER BY `id` DESC LIMIT 0,1",array((int)$id,(int)$categ)),
	    "next"=>$this->db->query("SELECT * FROM `products` WHERE `id`>? and `category_id`=? ORDER BY `id` ASC LIMIT 0,1",array((int)$id,(int)$categ))
	);
    }
    
    //проверим есть категория или нет
    public function checkCateg($translit) {
	$res = $this->db->query("SELECT * FROM `category` WHERE `translit`=?",array($translit));
	if($res->result_id->num_rows==1){
	    return $res;
	}else{
	    show_404();
	}
    }
    //получим статистику по количеству страниц в бд для pagination
    public function paginationProduct($id){
	return $this->db->query("SELECT count(*) as count  FROM `products` WHERE `category_id`=".(int)$id);
    }
    
    
    public function news($categ=1,$limit=0) {
	return array(
	    "count"=>$this->db->query("SELECT count(*)as count FROM `pages` WHERE `category_id`=".(int)$categ),
	    "news"=>$this->db->query("SELECT `pages`.*, `files`.`name` as `img` FROM `pages` JOIN `files` ON `files`.`id`=`pages`.`photo`  WHERE `category_id`=".(int)$categ." ORDER BY `id` DESC LIMIT ".(int)$limit.",5")
	);
    }
    
    public function media() {
	$media=$this->db->query("SELECT `pages`.*, `files`.`name` as `img` FROM `pages` JOIN `files` ON `files`.`id`=`pages`.`photo` WHERE `category_id`=3");
	foreach($media->result() as $row){
	    $row->images=$this->db->query("SELECT * FROM `page_file` JOIN `files` ON `page_file`.`file_id`=`files`.`id` WHERE `page_file`.`page_id`=".$row->id)->result();
	}
	return $media;
    }
    
    public function last() {
	return $this->db->query("SELECT `pages`.*, `files`.`name` as `img` FROM `pages` JOIN `files` ON `files`.`id`=`pages`.`photo`  WHERE `category_id`=1 ORDER BY `id` DESC LIMIT 0,3");
    }
    
    public function get_page($translit,$id=1) {
	return $this->db->query("SELECT `pages`.*, `files`.`name` as `img` FROM `pages` JOIN `files` ON `files`.`id`=`pages`.`photo` WHERE `category_id`=? and `translit`=?",array($id,$translit));
    }
    
    public function get_photo($id) {
	return $this->db->query("SELECT * FROM `files` WHERE `id`=?",array((int)$id));
    }
    
}