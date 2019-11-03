<?php
class Customer extends CI_Model {
	function login($userName, $password) {
		$this->db->select ( 'CUSTOMER_ID', 'USERNAME', 'FIRST_NAME', 'MIDDLE_NAME', 'LAST_NAME', 'PHONE_NUMBER', 'EMAIL_ID' );
		$this->db->from ( 'CUSTOMER' );
		$this->db->where ( 'USERNAME', $userName );
		$this->db->where ( 'PASSWORD', $password );
		$this->db->limit ( 1 );
		
		$query = $this->db->get ();
		if ($query->num_rows () == 1) {
			return $query->result ();
		} else {
			return false;
		}
	}
}