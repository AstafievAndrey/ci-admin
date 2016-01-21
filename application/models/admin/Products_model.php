<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Products_model extends CI_Model{
    
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
                'rules' => 'required|max_length[255]|is_unique[`products`.`translit`]',
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
    
    public function products($limit=0) {
	return $this->db->query("SELECT `products`.*, `category`.`name` as `category_name` from `products` "
		. "JOIN `category` ON `products`.`category_id`=`category`.`id`"
		. "ORDER BY id DESC LIMIT ".(int)$limit.",10");
    }
    
    //получим статистику по количеству страниц в бд для pagination
    public function pagination(){
	return $this->db->query("SELECT count(*) as count FROM `products`");
    }
    
    //выборка категорий
    public function category() {
	return $this->db->query("SELECT * FROM `category`");
    }
    
    //выберем все картики из бд
    public function get_images() {
	return $this->db->query("SELECT * FROM `files` WHERE `type`='img' ORDER BY id DESC");
    }
    
    //получим запись из бд
    public function getProduct($id) {
	return $this->db->query("SELECT `products`.* FROM `products` "
		. "WHERE `products`.`id`=?",array((int)$id));
    }
    
    //получим файлы связанные с продуктом
    public function product_file($id) {
	return $this->db->query("SELECT * FROM `product_file` JOIN `files` ON `files`.`id`=`product_file`.`file_id` WHERE `product_file`.`product_id`=?",array((int)$id));
    }
    
    //добавляем запись в бд
    public function insert() {
	for($i=1,$str="?";$i<count($this->input->post());$i++) $str.=",?";
	return $this->db->query("INSERT INTO `products` (".implode(",",array_keys($this->input->post())).",date,last_changes) VALUES(".$str.",CURRENT_TIMESTAMP,'".date("Y-m-d H-i-s")."')",array_values($this->input->post()));
    }
    
    //отредактируем запись
    public function update() {
	$id=$_POST["id"];unset($_POST["id"]);unset($_POST["old_translit"]);
	$str=implode("= ?,",array_keys($this->input->post()))." = ?";
	$this->db->query("UPDATE `products` "
		. "SET ".$str." "
		. "WHERE `id`=".(int)$id,
		array_values($this->input->post()));
	return $id;
    }
    
    //удалим запись из бд
    public function delete($id) {
	$this->db->query("DELETE from `product_file` WHERE `product_id`=".(int)$id);
	return $this->db->query("DELETE from `products` WHERE `id`=".(int)$id);
    }
    
    //удалим из бд файл который прикреплен к товару
    public function delete_product_file($id=0) {
	return $this->db->query("DELETE FROM `product_file`WHERE `product_file`.`file_id`=".(int)$id);
    }
    
    //прикрепим к странице новые изображения и проверим нет ли уже такой записи в бд
    public function edit_insert_image() {
	$id=(int)$this->input->post("id");
	foreach($this->input->post("imgs") as $row){
	    if($this->db->query("SELECT * FROM `product_file` WHERE `file_id`=? and `product_id`=?",
		    array((int)$row,$id))->result_id->num_rows==0
		){
		$this->db->query("INSERT INTO `product_file` (`product_id`,`file_id`) VALUES(".$id.",".(int)$row.")");
		}
	}
	unset($_POST["imgs"]);
    }
    
    //прикрепим к странице изображения
    public function insert_images($imgs) {
	$id = $this->db->query("SELECT MAX(`id`) as `id` FROM `products`")->result()[0]->id;
	foreach($imgs as $row){
	    $this->db->query("INSERT INTO `product_file` (`product_id`,`file_id`) VALUES(".$id.",".$row.")");
	}
    }
    
}