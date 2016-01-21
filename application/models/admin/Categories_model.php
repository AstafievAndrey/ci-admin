<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Categories_model extends CI_Model{

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
    
    //получим список все категорий
    public function getCategories($limit) {
	return array(
	    "count"=>$this->db->query("SELECT count(*) as count FROM `category`"),
	    "categ"=>$this->db->query("SELECT * FROM `category` ORDER BY `id` DESC LIMIT ?,10",array($limit))
	);
    }
    
    //добавляем запись в бд
    public function insert() {
	for($i=1,$str="?";$i<count($this->input->post());$i++) $str.=",?";
	return $this->db->query("INSERT INTO `category` (".implode(",",array_keys($this->input->post())).") VALUES(".$str.")",array_values($this->input->post()));
    }
    
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
                'field' => 'name',
                'label' => 'name',
                'rules' => 'required|max_length[255]',
		'errors' => array(
			    'required' => 'Поле %s не должно быть пустым.',
			    'max_length' =>'Превысили максимальную длину поля %s.'
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
    
    
}