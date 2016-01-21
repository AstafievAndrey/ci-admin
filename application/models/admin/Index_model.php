<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Index_model extends CI_Model{
    
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
    
    //получим статистику по количеству товаров в бд
    public function countProducts(){
	return $this->db->query("SELECT count(*) as count FROM `products`");
    }
    
    //кол-во товаров в каждой категории
    public function countCategoryProducts() {
	return $this->db->query("
		SELECT  `category`.`id` ,  `category`.`name` , COUNT(  `category`.`id` ) AS count
		FROM  `products` 
		JOIN  `category` ON  `products`.`category_id` =  `category`.`id` 
		GROUP BY  `category`.`id`");
    }
    
    //получим статистику по количеству страниц в бд
    public function countPages(){
	return $this->db->query("SELECT count(*) as count FROM `pages`");
    }
    
    //общее количество файлов
    public function countFiles(){
	return $this->db->query("SELECT count(*) as count FROM `files`");
    }
    
    //общее количество файлов
    public function countFilesType(){
	return $this->db->query("
		SELECT  `files`.`type` , COUNT(  `files`.`type` ) AS count
		FROM  `files` 
		GROUP BY  `files`.`type`");
    }
    
    //количество записей по категориям
    public function countCategory() {
	return $this->db->query("
		SELECT  `category`.`id` ,  `category`.`name` , COUNT(  `category`.`id` ) AS count
		FROM  `pages` 
		JOIN  `category` ON  `pages`.`category_id` =  `category`.`id` 
		GROUP BY  `category`.`id`");
    }
    
}