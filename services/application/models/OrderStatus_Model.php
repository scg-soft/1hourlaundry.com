<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class OrderStatus_Model extends MY_Model {
	public $_table = 'ORDER_STATUS';
	public $return_type = 'array';
	
	function __construct()
	{
		//$this->belongs_to['order'] = 'Order_Model';
		parent::__construct();
		
	}
	public $before_create = array (
			'pre_insert_data'
	);
	function pre_insert_data($data) {
		$data ['updated_time'] = date ( 'Y-m-d H:i:s' );
		
		return $data;
	}
}