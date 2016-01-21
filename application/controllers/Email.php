<?php

/* 
 * Контроллер для отправки сообщений
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Email extends CI_Controller {
    
    public function __construct() {
	parent::__construct();
	$this->load->library('email');
    }
    
    public function index() {
	
	if(!is_null($this->input->post("name"))&&!is_null($this->input->post("phone"))
	    &&($this->input->post("phone")!=="")&&($this->input->post("name")!=="")){
	    $config["mailtype"]="html";
	    $this->email->initialize($config);
	    $this->email->from('insite.space@gmail.com');
	    $this->email->to('astafievandrejnikolaevich@gmail.com');
	    $this->email->subject('Заявка с сайта');
	    $this->email->message('<h2>Имя:'.$this->input->post("name").'<br> Телефон:'.$this->input->post("phone").'</h2>');
	    if ( ! $this->email->send()){
		echo json_encode(array("result"=>0));
	    }else{
		echo json_encode(array("result"=>1));
	    }
	}else{
	    echo json_encode(array("result"=>0));
	}
    }
    
}