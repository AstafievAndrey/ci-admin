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
    
    
}