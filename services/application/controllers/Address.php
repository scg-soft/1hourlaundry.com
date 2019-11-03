<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
require APPPATH . '/libraries/REST_Controller.php';
class Address extends REST_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->library ( 'form_validation' );
		$this->load->model ( 'Address_Model' );
		$this->load->model ( 'Customer_Model' );
	}
	function add_put() {
		try {
			$address = $this->put ();
			if (null != $address || empty ( $address )) {
				throw new Exception ( 'Invalid data to add address for the customer' );
			}
			$this->form_validation->set_data ( $address );
			if ($this->form_validation->run ( 'address_add' ) != false) {
				
				$address_id = $this->Address_Model->insert ( $address );
				
				if (! $address_id) {
					throw new Exception ( 'internal database error while inserting db record' );
				} else {
					$customer_id = $this->uri->segment ( 3 );
					
					if (isset ( $customer_id )) {
						$customer = $this->Customer_Model->get_by ( array (
								'CUSTOMER_ID' => $customer_id 
						) );
						$customer ['PRIME_ADDRESS_ID'] = $address_id;
						$this->Customer_Model->update ( $customer_id, $customer );
						$this->response ( array (
								'status' => 'SUCCESS',
								'message' => 'Address Added',
								'payload' => $address_id 
						), REST_Controller::HTTP_OK );
					} else {
						throw new Exception ( 'Internal database error to insert the record' );
					}
				}
			} else {
				$this->response ( array (
						'status' => 'FAIL',
						'message' => $this->form_validation->get_errors_as_array () 
				), REST_Controller::HTTP_BAD_REQUEST );
			}
		} catch ( Exception $e ) {
			error_log ( 'ERROR:Failed to Add the customer address with exception :' . $e->getMessage () );
			$this->response ( array (
					'status' => 'FAILED',
					'message' => 'Internale Error ' . $e->getMessage () 
			), REST_Controller::HTTP_FORBIDDEN );
		}
	}
	function update_post() {
		try {
			
			$address_id = $this->uri->segment ( 3 );
			if (null != $address_id || empty ( $address_id )) {
				throw new Exception ( 'Invalid Address Identification number to update the record' );
			}
			$address = $this->post ();
			if (null != $address || empty ( $address )) {
				throw new Exception ( 'Invalid Address data to update the record' );
			}
			$this->form_validation->set_data ( $address );
			if ($this->form_validation->run ( 'address_add' ) != false) {
				
				$address_update = $this->Address_Model->update ( $address_id, $address );
				
				if (! $address_update) {
					throw new Exception ( 'internal database error while inserting db record' );
				} else {
					
					$this->response ( array (
							'status' => 'SUCCESS',
							'message' => 'Address Added',
							'payload' => $address_id 
					), REST_Controller::HTTP_OK );
				}
			} else {
				$this->response ( array (
						'status' => 'FAIL',
						'message' => $this->form_validation->get_errors_as_array () 
				), REST_Controller::HTTP_BAD_REQUEST );
			}
		} catch ( Exception $e ) {
			error_log ( 'ERROR:Failed to Update the customer address with exception :' . $e->getMessage () );
			$this->response ( array (
					'status' => 'FAILED',
					'message' => 'Internale Error ' . $e->getMessage () 
			), REST_Controller::HTTP_FORBIDDEN );
		}
	}
}