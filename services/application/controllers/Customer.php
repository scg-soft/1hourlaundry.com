<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
require APPPATH . '/libraries/REST_Controller.php';
class Customer extends REST_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->library ( 'form_validation' );
		$this->load->model ( 'Customer_Model' );
		$this->load->library ( 'email' );
	}
	function login_post() {
		try {
			$login = $this->post ();
			if( empty($login) ){
				throw new Exception('Invalid data to login the customer');
			}
			$this->form_validation->set_data ( $login );
			if ($this->form_validation->run ( 'customer_login' ) != false) {
				$userName = $this->post ( 'username', TRUE );
				$password = $this->post ( 'password', TRUE );
				
				$customer = $this->Customer_Model->get_by ( array (
						'username' => $userName,
						'password' => $password 
				) );
				
				if (isset ( $customer ['CUSTOMER_ID'] )) {
					$customer = array_change_key_case ( $customer, CASE_LOWER );
					
					$this->response ( array (
							'status' => 'SUCCESS',
							'message' => 'LoggedIn',
							'payload' => $customer 
					), REST_Controller::HTTP_OK );
				} else {
					$this->response ( array (
							'status' => 'FAIL',
							'message' => 'Customer not found in the database' 
					), REST_Controller::HTTP_NOT_FOUND );
				}
			} else {
				$this->response ( array (
						'status' => 'FAILED',
						'message' => $this->form_validation->get_errors_as_array () 
				), REST_Controller::HTTP_BAD_REQUEST );
			}
		} catch ( Exception $e ) {
			error_log ( 'ERROR:Failed to Login the customer with exception :' . $e->getMessage () );
			$this->response ( array (
					'status' => 'FAILED',
					'message' => 'Internale Error ' . $e->getMessage () 
			), REST_Controller::HTTP_FORBIDDEN );
		}
	}
	function find_get() {
		$this->response ( 'LoggedIn' );
	}
	function register_put() {
		try {
			$customer = $this->put ();
			if(empty($customer)){
				throw new Exception('Invalid data to register the customer');
			}
			
			$this->form_validation->set_data ( $customer );
			if ($this->form_validation->run ( 'customer_register' ) != false) {
				$username = $customer ['username'];
				$db_customer = $this->Customer_Model->get_by ( array (
						'USERNAME' => $username 
				) );
				if (! isset ( $db_customer ['CUSTOMER_ID'] )) {
					$customer_id = $this->Customer_Model->insert ( $customer );
					if (! $customer_id) {
						$this->response ( array (
								'status' => 'FAIL',
								'message' => 'internal database error while inserting db record' 
						), REST_Controller::HTTP_INTERNAL_SERVER_ERROR );
					} else {
						$name = $customer ['first_name'] .' '. $customer ['last_name'];
						$customer ['customer_id'] = $customer_id;
						$this->sendemail ( $username, $name, 'Registration Confirmed:Thank you', 'Thank you ' . $name . ' for registering the 1hrlaundry app' );
						$this->response ( array (
								'status' => 'SUCCESS',
								'message' => 'Customer Created',
								'payload' => $customer 
						), REST_Controller::HTTP_OK );
					}
				} else {
					$this->response ( array (
							'status' => 'FAIL',
							'message' => 'Customer already exists' 
					), REST_Controller::HTTP_INTERNAL_SERVER_ERROR );
				}
			} else {
				$this->response ( array (
						'status' => 'FAIL',
						'message' => $this->form_validation->get_errors_as_array () 
				), REST_Controller::HTTP_BAD_REQUEST );
			}
		} catch ( Exception $e ) {
			error_log ( 'ERROR:Failed to register the customer with exception :' . $e->getMessage () );
			$this->response ( array (
					'status' => 'FAILED',
					'message' => 'Internale Error ' . $e->getMessage () 
			), REST_Controller::HTTP_FORBIDDEN );
		}
	}
	function changepassword_post() {
		try {
			$data = $this->post();
			if( empty($data)){
				throw new Exception('Invalid data to process the change passsword');
			}
			$this->form_validation->set_data ( $data );
			if ($this->form_validation->run ( 'customer_changepassword' ) != false) {
				$userName = $data ['username'];
				$password = $data['password'];
				$customer = $this->Customer_Model->get_by ( array (
						'USERNAME' => $userName 
				) );
				if (isset ( $customer ['CUSTOMER_ID'] )) {
					$customer_id = $this->Customer_Model->update ( $customer ['CUSTOMER_ID'], array (
							'PASSWORD' => $password,
							'STATUS' => 'ACTIVE' 
					) );
					$customer = array_change_key_case ( $customer, CASE_LOWER );
					$this->response ( array (
							'status' => 'SUCCESS',
							'message' => 'Customer new password Updated',
							'payload' => $customer 
					), REST_Controller::HTTP_OK );
				} else {
					$this->response ( array (
							'status' => 'FAIL',
							'message' => 'Customer not found in the database' 
					), REST_Controller::HTTP_NOT_FOUND );
				}
			}else{
				$this->response ( array (
						'status' => 'FAIL',
						'message' => $this->form_validation->get_errors_as_array ()
				), REST_Controller::HTTP_BAD_REQUEST );
			}
		} catch ( Exception $e ) {
			error_log ( 'ERROR:Failed to change the password with exception :' . $e->getMessage () );
			$this->response ( array (
					'status' => 'FAILED',
					'message' => 'Internale Error ' . $e->getMessage () 
			), REST_Controller::HTTP_FORBIDDEN );
		}
	}
	function forgotpassword_post() {
		try {
			$userName = $this->post ( 'username', TRUE );
			
			if (!empty( $userName )) {
				$db_customer = $this->Customer_Model->get_by ( array (
						'USERNAME' => $userName 
				) );
				if (isset ( $db_customer ['CUSTOMER_ID'] )) {
					$name = $db_customer ['FIRST_NAME'] . ' ' . $db_customer ['LAST_NAME'];
					$digits = 4;
					$value = rand ( pow ( 10, $digits - 1 ), pow ( 10, $digits ) - 1 );
					$this->sendemail ( $userName, $name, 'Account update :Your secured information', 'Dear ' . $name . '\n' . 'Please use your temporay password ' . $value . ' to login into your account in 1hrlaundry. please change the passowrd once you loggedin.' );
					$data = array (
							'PASSWORD' => $value,
							'STATUS' => 'FORGOTPASSWORD' 
					);
					$customer_id = $this->Customer_Model->update ( $db_customer ['CUSTOMER_ID'], $data );
					$this->response ( array (
							'status' => 'SUCCESS',
							'message' => 'Temporay password generated and emailed' 
					), REST_Controller::HTTP_OK );
				} else {
					$this->response ( array (
							'status' => 'FAIL',
							'message' => 'Customer not found in our system' 
					), REST_Controller::HTTP_NOT_FOUND );
				}
			} else {
			 throw new Exception('Invalid data to process forgot password');
			}
		} catch ( Exception $e ) {
			error_log ( 'ERROR:Failed to execute forgotpassword for the customer with exception :' . $e->getMessage () );
			$this->response ( array (
					'status' => 'FAILED',
					'message' => 'Internale Error ' . $e->getMessage () 
			), REST_Controller::HTTP_FORBIDDEN );
		}
	}
	function update_post() {
		try {
			$customer_id = $this->uri->segment ( 3 );
			$customer = $this->post ();
			if (!empty( $customer_id ) && !empty( $customer )) {
				$this->form_validation->set_data ( $customer );
				if ($this->form_validation->run ( 'customer_update' ) != false) {
					$customer_update = $this->Customer_Model->update ( $customer_id, $customer );
					if (isset ( $customer_update )) {
						$customer = array_change_key_case ( $customer, CASE_LOWER );
						$customer ['customer_id'] = $customer_id;
						unset ( $customer ['password'] );
						$this->response ( array (
								'status' => 'SUCCESS',
								'message' => 'Customer data Updated',
								'payload' => $customer 
						), REST_Controller::HTTP_OK );
					} else {
						$this->response ( array (
								'status' => 'FAIL',
								'message' => 'Customer not found in the database' 
						), REST_Controller::HTTP_NOT_FOUND );
					}
				} else {
					$this->response ( array (
							'status' => 'FAILED',
							'message' => $this->form_validation->get_errors_as_array () 
					), REST_Controller::HTTP_BAD_REQUEST );
				}
			} else {
				throw  new Exception('Customer data should provide to update the record');
			}
		} catch ( Exception $e ) {
			error_log ( 'ERROR:Failed to update the customer with exception :' . $e->getMessage () );
			$this->response ( array (
					'status' => 'FAILED',
					'message' => 'Internale Error ' . $e->getMessage () 
			), REST_Controller::HTTP_FORBIDDEN );
		}
	}
	function sendemail($senderEmail, $senderName, $emailSubject, $emailBody) {
		try {
			$this->email->set_newline ( "\r\n" );
			$this->email->from ( 'no.reply@1hrlaundry.com', '1HRLAUNDRY.com' );
			$this->email->to ( $senderEmail, $senderName );
			$this->email->subject ( $emailSubject );
			$this->email->message ( $emailBody );
			if ($this->email->send ()) {
				return 'Success';
			} else {
				return 'Fail';
			}
		} catch ( Exception $e ) {
			error_log ( 'ERROR:Failed to send an email with exception :' . $e->getMessage () );
		}
	}
}

?>