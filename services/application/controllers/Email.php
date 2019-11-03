<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
require APPPATH . '/libraries/REST_Controller.php';
class Email extends REST_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->library ( 'form_validation' );
		$this->load->library ( 'email' );
		
	}
	function send_post() {
		try{
		$emailData = $this->post ();
		if( empty($emailData) ){
			throw new Exception('Invalid data to send an email');
		}
		$this->form_validation->set_data ( $emailData );
		if ($this->form_validation->run ( 'bulk_email' ) != false) {
			$customername = $emailData['customername'];
			$customeremail = $emailData['customeremail'];
			$customerphone = $emailData['customerphone'];
			$customeremailSubject = $emailData['emailSubject'];
			$customeremailBody = $emailData['emailBody'];
			$body = $customeremailBody .'<br><br>'. 'Thanks and Regards'.'<br>'. $customername . '<br>'.'Contact Number:'.$customerphone;
			$return = $this->sendemail ( $customeremail, $customername, $customeremailSubject, $body);
			if($return = 'Success'){
			$this->response ( array (
					'status' => 'SUCCESS',
					'message' => 'Email Successfully sent'
			), REST_Controller::HTTP_OK );
			}else{
				$this->response ( array (
						'status' => 'FAIL',
						'message' => 'Email sent failed'
				), REST_Controller::HTTP_FORBIDDEN );
			}
		}else{
			$this->response ( array (
							'status' => 'FAILED',
							'message' => $this->form_validation->get_errors_as_array () 
					), REST_Controller::HTTP_BAD_REQUEST );
		}
		}catch (Exception $e){
			error_log ( 'ERROR:Failed to send an email with exception :' . $e->getMessage () );
			$this->response ( array (
					'status' => 'FAILED',
					'message' => 'Internale Error ' . $e->getMessage ()
			), REST_Controller::HTTP_FORBIDDEN );
		}
	}
	function sendemail($senderEmail, $senderName, $emailSubject, $emailBody) {
		/*$config = array (
				'protocol' => 'smtp',
				'smtp_host' => 'sg2plcpnl0036.prod.sin2.secureserver.net',
				'smtp_port' => '465',
				'smtp_user' => 'no.reply@1hrlaundry.com',
				'smtp_pass' => '1hrlaundry@321',
				'mailtype' => 'html',
				'charset' => 'iso-8859-1',
				'wordwrap' => TRUE 
		);*/
		try {
		$this->email->set_newline ( "\r\n" );
		$this->email->from ( $senderEmail, $senderName );
		$this->email->to ( 'info@1hrlaundry.com', '1hrlaundry.com' );
		$this->email->subject ( $emailSubject );
		$this->email->message ( $emailBody );
		if ($this->email->send ()) {
			return 'Success';
		} else {
			return 'Fail';
		}
		}catch (Exception $e){
			throw new Exception('Failed to send an email:'.$e->getMessage ());
		}
	}
}