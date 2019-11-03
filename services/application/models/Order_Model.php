<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Order_Model extends MY_Model {
	public $_table = "ORDER";
	public $return_type = "array";
	public $primary_key = "ORDER_ID";
    
		function __construct() {
		
		//$this->has_many ['statuses'] = 'OrderStauts_Model';
		parent::__construct ();
	}
	public $before_create = array (
			'pre_insert_data' 
	);
	
	public $before_update = array (
			'pre_update_data'
	);
	public $after_get = array (
			'remove_sensitive_data'
	);
	
	
	function pre_update_data($data) {
		$pick_up_datetime = date ( 'Y-m-d H:i:s', strtotime ( $data ['pick_up_datetime'] ) );
		$drop_of_datetime = date ( 'Y-m-d H:i:s', strtotime ( $data ['drop_of_datetime'] ) );
		$data ['PICK_UP_DATETIME'] = $pick_up_datetime;
		$data ['DROP_OF_DATETIME'] = $drop_of_datetime;
		unset ( $data ['pick_up_datetime'] );
		unset ( $data ['drop_of_datetime'] );
		return $data;
	}
	
	
	function pre_insert_data($data) {
		$pick_up_datetime = date ( 'Y-m-d H:i:s', strtotime ( $data ['pick_up_datetime'] ) );
		$drop_of_datetime = date ( 'Y-m-d H:i:s', strtotime ( $data ['drop_of_datetime'] ) );
		$data ['PICK_UP_DATETIME'] = $pick_up_datetime;
		$data ['DROP_OF_DATETIME'] = $drop_of_datetime;
		unset ( $data ['pick_up_datetime'] );
		unset ( $data ['drop_of_datetime'] );
		return $data;
	}
	
	public function remove_sensitive_data($result) {
		unset ( $result ['ORDER_CREATION_DATETIME'] );
		$result = array_change_key_case ( $result, CASE_LOWER );
		return $result;
	}
}