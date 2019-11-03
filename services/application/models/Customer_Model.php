<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Customer_Model extends MY_Model {
	public $_table = 'CUSTOMER';
	public $primary_key = 'CUSTOMER_ID';
	public $return_type = 'array';
	/*public  $protected_attributes=array('username');*/
	public $after_get = array (
			'remove_sensitive_data' 
	);
	public $before_create = array (
			'pre_insert_data' 
	);
	public $before_update = array (
			'post_update_data' 
	);
	public $after_update = array (
			'remove_sensitive_data' 
	);
	public function post_update_data($result) {
		$result ['updated_time'] = date ( 'Y-m-d H:i:s' );
		
		return $result;
	}
	
	public function remove_sensitive_update_data($result) {
		unset ( $result ['password'] );
		unset ( $result ['prime_address_id'] );
		unset ( $result ['alternate_address_id'] );
		unset ( $result ['created_by'] );
		unset ( $result ['created_time'] );
		unset ( $result ['updated_time'] );
		return $result;
	}
	
	public function remove_sensitive_data($result) {
		unset ( $result ['PASSWORD'] );
		unset ( $result ['PRIME_ADDRESS_ID'] );
		unset ( $result ['ALTERNATE_ADDRESS_ID'] );
		unset ( $result ['CREATED_BY'] );
		unset ( $result ['CREATED_TIME'] );
		unset ( $result ['UPDATED_TIME'] );
		return $result;
	}
	public function pre_insert_data($result) {
		$result ['status'] = 'REGISTERED';
		$result ['created_by'] = $result ['username'];
		$result ['prime_address_id'] = null;
		$result ['alternate_address_id'] = null;
		$result ['created_time'] = date ( 'Y-m-d H:i:s' );
		$result ['updated_time'] = date ( 'Y-m-d H:i:s' );
		
		return $result;
	}
}