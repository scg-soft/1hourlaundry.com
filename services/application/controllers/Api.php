<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';

class api extends REST_Controller {

	function hello_get(){
		
		$data['orderCreateDate'] = date("Y-m-d");
		$data['phoneNumber'] = "1231231231";
		$data['emailId'] = "abc1@gmail.com";
		$data['pickupAddress'] = "my address1";
		$data['pickupTime'] = time();
		$data['instructions'] = "";
		$data['status'] = "PickedUp";	


		$data1['orderCreateDate'] = date("Y-m-d");
		$data1['phoneNumber'] = "1231231231";
		$data1['emailId'] = "abc2@gmail.com";
		$data1['pickupAddress'] = "my address2";
		$data1['pickupTime'] = time();
		$data1['instructions'] = "";
		$data1['status'] = "Completed";	

		$orders =  array('0' => $data, '1'=>$data1);
		$this->response($orders);
	}

	function hello_post(){
		$name=$this->post('name');

		$data['id'] = "12";
		$data['content'] = "Hello 123";
		$data['mydata'] = "Hai " . $name ;

		$data1['id'] = "13";
		$data1['content'] = "Hello 1234";
		$data1['mydata'] = "Hai Mister " . $name ;

		$data2['id'] = "14";
		$data2['content'] = "Hello 34";
		$data2['mydata'] = "Hey " . $name ;

		$response = array('0' => $data, '1'=> $data1, '2'=> $data2);

		$this->response($response);
	}

}

?>
