<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Pages_model extends CI_Model{
    
    public $config_validation_add = array(
        array(
                'field' => 'seo_title',
                'label' => 'seo_title',
                'rules' => 'required|max_length[255]',
		'errors' => array(
			    'required' => 'Поле %s не должно быть пустым.',
			    'max_length' =>'Превысили максимальную длину поля %s.'
		    )
        ),
	array(
                'field' => 'seo_desc',
                'label' => 'seo_desc',
                'rules' => 'max_length[400]',
		'errors' => array(
			    'max_length' =>'Превысили максимальную длину поля %s.'
		    )
        ),
        array(
                'field' => 'translit',
                'label' => 'translit',
                'rules' => 'required|max_length[255]|is_unique[`pages`.`translit`]',
		'errors' => array(
			    'required' => 'Поле %s не должно быть пустым.',
			    'is_unique'=>'Такое поле существет, %s должно быть уникальным.',
			    'max_length' =>'Превысили максимальную длину поля %s.'
		    )
        ),
	array(
                'field' => 'category_id',
                'label' => 'category_id',
                'rules' => 'required|numeric',
		'errors' => array(
			    'required' => 'Поле %s не должно быть пустым.',
			    'numeric' =>'Поле %s должно содержать число.'
		    )
        ),
	array(
                'field' => 'description',
                'label' => 'description',
                'rules' => 'required',
		'errors' => array(
				'required' => 'Поле %s не должно быть пустым.',
			)
        )
    );
    
    public $config_validation_edit = array(
        array(
                'field' => 'seo_title',
                'label' => 'seo_title',
                'rules' => 'required|max_length[255]',
		'errors' => array(
			    'required' => 'Поле %s не должно быть пустым.',
			    'max_length' =>'Превысили максимальную длину поля %s.'
		    )
        ),
	array(
                'field' => 'seo_desc',
                'label' => 'seo_desc',
                'rules' => 'max_length[400]',
		'errors' => array(
			    'max_length' =>'Превысили максимальную длину поля %s.'
		    )
        ),
        array(
                'field' => 'translit',
                'label' => 'translit',
                'rules' => 'required|max_length[255]',
		'errors' => array(
			    'required' => 'Поле %s не должно быть пустым.',
			    'max_length' =>'Превысили максимальную длину поля %s.'
		    )
        ),
	array(
                'field' => 'category_id',
                'label' => 'category_id',
                'rules' => 'required|numeric',
		'errors' => array(
			    'required' => 'Поле %s не должно быть пустым.',
			    'numeric' =>'Поле %s должно содержать число.'
		    )
        ),
	array(
                'field' => 'description',
                'label' => 'description',
                'rules' => 'required',
		'errors' => array(
				'required' => 'Поле %s не должно быть пустым.',
			)
        )
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
    
    //удалим из бд файл который прикреплен к странице
    public function delete_page_file($id=0) {
	return $this->db->query("DELETE FROM `page_file`WHERE `page_file`.`file_id`=".(int)$id);
    }
    
    public function page_file($id) {
	return $this->db->query("SELECT * FROM `page_file` JOIN `files` ON `files`.`id`=`page_file`.`file_id` WHERE `page_file`.`page_id`=?",array((int)$id));
    }
    
    //прикрепим к странице новые изображения и проверим нет ли уже такой записи в бд
    public function edit_insert_image() {
	$id=(int)$this->input->post("id");
	foreach($this->input->post("imgs") as $row){
	    if($this->db->query("SELECT * FROM `page_file` WHERE `file_id`=? and `page_id`=?",
		    array((int)$row,$id))->result_id->num_rows==0
		){
		$this->db->query("INSERT INTO `page_file` (`page_id`,`file_id`) VALUES(".$id.",".(int)$row.")");
		}
	}
	unset($_POST["imgs"]);
    }
    
    //прикрепим к странице изображения
    public function insert_images($imgs) {
	$id = $this->db->query("SELECT MAX(`id`) as `id` FROM `pages`")->result()[0]->id;
	foreach($imgs as $row){
	    $this->db->query("INSERT INTO `page_file` (`page_id`,`file_id`) VALUES(".$id.",".$row.")");
	}
    }
    
    //выберем все картики из бд
    public function get_images() {
	return $this->db->query("SELECT * FROM `files` WHERE `type`='img' ORDER BY id DESC");
    }
    
    //удалим запись из бд
    public function delete($id) {
	$this->db->query("DELETE from `page_file` WHERE `page_id`=".(int)$id);
	return $this->db->query("DELETE from `pages` WHERE `id`=".(int)$id);
    }
    
    //отредактируем запись
    public function update() {
	$id=$_POST["id"];unset($_POST["id"]);unset($_POST["old_translit"]);
	$str=implode("= ?,",array_keys($this->input->post()))." = ?";
	$this->db->query("UPDATE `pages` "
		. "SET ".$str." "
		. "WHERE `id`=".(int)$id,
		array_values($this->input->post()));
	return $id;
    }
    
    //получим запись из бд
    public function getPage($id) {
	return $this->db->query("SELECT `pages`.* FROM `pages` "
		. "WHERE `pages`.`id`=?",array((int)$id));
    }
    
    //добавляем запись в бд
    public function insert() {
	for($i=1,$str="?";$i<count($this->input->post());$i++) $str.=",?";
	return $this->db->query("INSERT INTO `pages` (".implode(",",array_keys($this->input->post())).",date,last_changes) VALUES(".$str.",CURRENT_TIMESTAMP,'".date("Y-m-d H-i-s")."')",array_values($this->input->post()));
    }
    
    //выборка категорий
    public function category() {
	return $this->db->query("SELECT * FROM `category`");
    }
    
    //выборка записей
    public function pages( $limit=0) {
	return $this->db->query("SELECT `pages`.*, `category`.`name` as `category_name` from `pages` "
		. "JOIN `category` ON `pages`.`category_id`=`category`.`id`"
		. "ORDER BY id DESC LIMIT ".$limit.",10");
    }
    
    //получим статистику по количеству страниц в бд для pagination
    public function pagination(){
	return $this->db->query("SELECT count(*) as count FROM `pages`");
    }
    
}