<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
require APPPATH . '/libraries/REST_Controller.php';
class Orders extends REST_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->library ( 'form_validation' );
		$this->load->model ( 'Order_Model' );
		$this->load->model ( 'OrderStatus_Model' );
	}
	function orderByName_get() {
		$customer_name = $this->uri->segment ( 3 );
		if (isset ( $customer_name )) {
		} else {
			$this->response ( array (
					'status' => 'FAILED',
					'message' => 'Contact Name should provide' 
			), REST_Controller::HTTP_BAD_REQUEST );
		}
	}
	
	function list_get() {
		try {
			$customer_id = $this->uri->segment ( 3 );
			if (isset ( $customer_id )) {
				$orders = $this->Order_Model->get_many_by ( array (
							'CUSTOMER_ID' => $customer_id
					) );
				if (isset ( $orders )) {

                    $i = -1;
                    foreach($orders as $order){
                        $i++;
                        $order_status = $this->OrderStatus_Model->get_by ( array (
							    'ORDER_ID' => $orders[$i] ['order_id'] 
					    ) );
                        
					    $status = $order_status ['ORDER_STATUS'];
					    $orders[$i] ['order_status'] = $status;
                    }
                    
                    $this->response ( array (
							'status' => 'SUCCESS',
							'message' => 'Details',
							'payload' => $orders
					), REST_Controller::HTTP_OK );
				} else {
					throw new Exception ( 'No order found in system with orderId:' . $order_id );
				}
				 $this->response ( array (
							'status' => 'SUCCESS',
							'message' => 'Details',
							'payload' => $orders
					), REST_Controller::HTTP_OK );
			} else {
				throw new Exception ( 'Invaid data to fetch Order record. customer shuld not be empty' );
			}
		} catch ( Exception $e ) {
			error_log ( 'ERROR: Failed to create a new order :' . $e->getMessage () );
			$this->response ( array (
					'status' => 'FAILED',
					'message' => 'Internale Error ' . $e->getMessage ()
			), REST_Controller::HTTP_FORBIDDEN );
		}
	}
	
	
	function Details_get() {
		try {
			$order_id = $this->uri->segment ( 3 );
			if (isset ( $order_id )) {
				$order = $this->Order_Model->get( $order_id );
				
				if (isset ( $order )) {
					$order_status = $this->OrderStatus_Model->get_by ( array (
							'ORDER_ID' => $order_id 
					) );
					$status = $order_status ['ORDER_STATUS'];
					$order ['order_status'] = $status;
					$this->response ( array (
							'status' => 'SUCCESS',
							'message' => 'Order Details',
							'payload' => $order 
					), REST_Controller::HTTP_OK );
				} else {
					throw new Exception ( 'No order found in system with orderId:' . $order_id );
				}
			} else {
				throw new Exception ( 'Invaid data to fetch Order record. OrderId shuld not be empty' );
			}
		} catch ( Exception $e ) {
			error_log ( 'ERROR: Failed to create a new order :' . $e->getMessage () );
			$this->response ( array (
					'status' => 'FAILED',
					'message' => 'Internale Error ' . $e->getMessage () 
			), REST_Controller::HTTP_FORBIDDEN );
		}
	}
	function create_put() {
		try {
			$order = $this->put ();
            unset ( $order ['order_status'] );
            unset ( $order ['order_id'] );
			if (empty ( $order )) {
				throw new Exception ( 'Invalid data to process the order' );
			}
			$this->form_validation->set_data ( $order );
			if ($this->form_validation->run ( 'order_create' ) != false) {
				$order_id = $this->Order_Model->insert ( $order );
				if (! $order_id) {
					throw new Exception ( 'internal database error while inserting db record into orders' );
				} else {
					$order ["order_id"] = $order_id;
					$order_status = array (
							'order_id' => $order_id,
							'order_status' => 'CREATED' 
					);
					$order_status_id = $this->OrderStatus_Model->insert ( $order_status );
					if ($order_status_id != 0) {
						throw new Exception ( 'internal database error while inserting db record into order_status ' . $order_status_id );
					} else {                        
						$this->sendemail ( $order ['customer_email_id'], $order ['customer_name'], 'Order Receipt from 1HrLaundry', 'Thank you ' . $order ['customer_name'] . "<br><br>" . ' You have made a order from 1HrLaundry. the Order ' . $order ['ORDER_ID'] . ' has been placed in the system. one of our representative will call you for further assistance.' . "<br><br>" . ' Thank you very much for your busiess with 1HrLaundry. Have a nice day.' );
                        $this->response ( array (
								'status' => 'SUCCESS',
								'message' => 'Order Created',
								'payload' => $order 
						), REST_Controller::HTTP_OK );
					}
				}
			} else {
				$this->response ( array (
						'status' => 'FAIL',
						'message' => $this->form_validation->get_errors_as_array () 
				), REST_Controller::HTTP_BAD_REQUEST );
			}
		} catch ( Exception $e ) {
			error_log ( 'ERROR: Failed to create a new order :' . $e->getMessage () );
			$this->response ( array (
					'status' => 'FAILED',
					'message' => 'Internale Error ' . $e->getMessage () 
			), REST_Controller::HTTP_FORBIDDEN );
		}
	}
	function update_post() {
		try {
			$order_id = $this->uri->segment ( 3 );
			if (empty ( $order_id )) {
				throw new Exception ( 'Invalid data to process the order' );
			}
			$order = $this->post ();
			if (empty ( $order )) {
				throw new Exception ( 'Invalid data to process the order' );
			}
			$this->form_validation->set_data ( $order );
			if ($this->form_validation->run ( 'order_update' ) != false) {
				$status = $order ['order_status'];
				unset ( $order ['order_status'] );
				$orderupdate_id = $this->Order_Model->update ( $order_id, $order );
				if (! isset ( $orderupdate_id )) {
					throw new Exception ( 'internal database error while updating db record into orders' );
				} else {
					$record = array (
							'order_id' => $order_id,
							'order_status' => $status 
					);
					$order_status = $this->OrderStatus_Model->get_by ( $record );
					if (! isset ( $order_status )) {
						$order_status_id = $this->OrderStatus_Model->insert ( $record );
						if ($order_status_id != 0) {
							throw new Exception ( 'internal database error while inserting db record into order_status ' . $order_status_id );
						} else {
							$order ['order_status'] = $status;
							$this->sendemail ( $order ['customer_email_id'], $order ['customer_name'], 'Order Receipt from 1HrLaundry', 'Thank you ' . $order ['customer_name'] . "<br><br>" . ' You have made a order from 1HrLaundry. the Order ' . $order ['ORDER_ID'] . ' has been placed in the system. one of our representative will call you for further assistance.' . "<br><br>" . ' Thank you very much for your busiess with 1HrLaundry. Have a nice day.' );
							$this->response ( array (
									'status' => 'SUCCESS',
									'message' => 'Order updated',
									'payload' => $order 
							), REST_Controller::HTTP_OK );
						}
					}
				}
			} else {
				$this->response ( array (
						'status' => 'FAIL',
						'message' => $this->form_validation->get_errors_as_array () 
				), REST_Controller::HTTP_BAD_REQUEST );
			}
		} catch ( Exception $e ) {
			error_log ( 'ERROR: Failed to create a new order :' . $e->getMessage () );
			$this->response ( array (
					'status' => 'FAILED',
					'message' => 'Internale Error ' . $e->getMessage () 
			), REST_Controller::HTTP_FORBIDDEN );
		}
	}
	function cancel_post() {
	}
	function sendemail($senderEmail, $senderName, $emailSubject, $emailBody) {
		$this->load->library ( 'email' );
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
	}
}
?>