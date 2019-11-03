<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
 
class Webservices extends REST_Controller{
	
	function  __construct(){
		parent::__construct();
	}
	
	function customerlogin_get(){
		$userName = $this->request->get('userName');
		$password = $this->request->get('password');
		$data = array(
					"foo" => $userName,
					"bar" => $password
				);
		//echo __FUNCTION__, " got $userName and $password\n";
		$this->response($data);
		/*
		$customerDAO = new CustomerDAO();
		$return =  $customerDAO ->login($userName,$password);
		if(!isset($return) and !empty($return) and !$return){
			return $return;
		}else{
			return $return;*/
	}


	
}

?>