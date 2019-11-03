<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Model_customer extends MY_Model {
	public $_table = 'CUSTOMER';
	public $primary_key = 'CUSTOMER_ID';
	public $return_type = 'array';
	public $after_get = array ('remove_sensitive_data');
	public $before_create = array ('pre_insert_data');

	public function remove_sensitive_data($result) {
		unset ( $result['PASSWORD'] );
		unset ( $result ['PRIME_ADDRESS_ID'] );
		unset ( $result ['ALTERNATE_ADDRESS_ID'] );
		unset ( $result ['CREATED_BY'] );
		unset ( $result ['CREATED_TIME'] );
		unset ( $result ['UPDATED_TIME'] );
		
		return $result;
	}


	public function pre_insert_data($result) {
		$result['CREATED_BY'] = $result['USERNAME'];
		$result['PRIME_ADDRESS_ID'] = null;
		$result['ALTERNATE_ADDRESS_ID'] = null;
		$result['CREATED_TIME'] = date('Y-m-d H:i:s');
		$result['UPDATED_TIME'] = date('Y-m-d H:i:s');

		return $result;
	}
}