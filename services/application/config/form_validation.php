<?php
$config = array (
		'customer_login' => array (
				array (
						'field' => 'username',
						'label' => 'username',
						'rules' => 'trim|required|valid_email' 
				),
				array (
						'field' => 'password',
						'label' => 'password',
						'rules' => 'trim|required' 
				) 
		),
		'customer_register' => array (
				array (
						'field' => 'username',
						'label' => 'username',
						'rules' => 'trim|required|valid_email' 
				),
				array (
						'field' => 'password',
						'label' => 'password',
						'rules' => 'trim|required' 
				),
				array (
						'field' => 'first_name',
						'label' => 'first_name',
						'rules' => 'trim|required' 
				),
				array (
						'field' => 'last_name',
						'label' => 'last_name',
						'rules' => 'trim|required' 
				),
				array (
						'field' => 'phone_number',
						'label' => 'phone_number',
						'rules' => 'trim|required' 
				),
				array (
						'field' => 'email_id',
						'label' => 'email_id',
						'rules' => 'trim|required|valid_email' 
				) 
		),
		'customer_changepassword' => array (
				array (
						'field' => 'username',
						'label' => 'username',
						'rules' => 'trim|required|valid_email' 
				),
				array (
						'field' => 'password',
						'label' => 'password',
						'rules' => 'trim|required' 
				) 
		),
		'customer_update' => array (
				array (
						'field' => 'username',
						'label' => 'username',
						'rules' => 'trim|required|valid_email' 
				),
				array (
						'field' => 'password',
						'label' => 'password',
						'rules' => 'trim|required' 
				),
				array (
						'field' => 'first_name',
						'label' => 'first_name',
						'rules' => 'trim|required' 
				),
				array (
						'field' => 'last_name',
						'label' => 'last_name',
						'rules' => 'trim|required' 
				),
				array (
						'field' => 'phone_number',
						'label' => 'phone_number',
						'rules' => 'trim|required' 
				),
				array (
						'field' => 'email_id',
						'label' => 'email_id',
						'rules' => 'trim|required|valid_email' 
				) 
		),
		
		'address_add' => array (
				
				array (
						'field' => 'address_1',
						'label' => 'address_1',
						'rules' => 'trim|required' 
				),
				array (
						'field' => 'city',
						'label' => 'city',
						'rules' => 'trim|required' 
				),
				array (
						'field' => 'state',
						'label' => 'state',
						'rules' => 'trim|required' 
				),
				array (
						'field' => 'zipcode',
						'label' => 'zipcode',
						'rules' => 'trim|required' 
				) 
		),
		'order_create' => array (
		
				array (
						'field' => 'customer_id',
						'label' => 'customer_id',
						'rules' => 'trim|required'
				),
				array (
						'field' => 'customer_phone',
						'label' => 'customer_phone',
						'rules' => 'trim|required'
				),
				array (
						'field' => 'customer_name',
						'label' => 'customer_name',
						'rules' => 'trim|required'
				),
				array (
						'field' => 'order_address_1',
						'label' => 'order_address_1',
						'rules' => 'trim|required'
				),
				array (
						'field' => 'order_address_2',
						'label' => 'order_address_2',
						'rules' => 'trim|required'
				),
				array (
						'field' => 'order_city',
						'label' => 'order_city',
						'rules' => 'trim|required'
				),
				array (
						'field' => 'order_state',
						'label' => 'order_state',
						'rules' => 'trim|required'
				),
				
				array (
						'field' => 'customer_email_id',
						'label' => 'customer_email_id',
						'rules' => 'trim|required|valid_email'
				),
				array (
						'field' => 'drop_of_datetime',
						'label' => 'drop_of_datetime',
						'rules' => 'trim|required'
				),
				array (
						'field' => 'pick_up_datetime',
						'label' => 'pick_up_datetime',
						'rules' => 'trim|required'
				)
		),
		
		'order_update' => array (
				array (
						'field' => 'order_status',
						'label' => 'order_status',
						'rules' => 'trim|required'
				),
				array (
						'field' => 'customer_id',
						'label' => 'customer_id',
						'rules' => 'trim|required'
				),
				array (
						'field' => 'customer_phone',
						'label' => 'customer_phone',
						'rules' => 'trim|required'
				),
				array (
						'field' => 'customer_name',
						'label' => 'customer_name',
						'rules' => 'trim|required'
				),
				array (
						'field' => 'order_address_1',
						'label' => 'order_address_1',
						'rules' => 'trim|required'
				),
				array (
						'field' => 'order_address_2',
						'label' => 'order_address_2',
						'rules' => 'trim|required'
				),
				array (
						'field' => 'order_city',
						'label' => 'order_city',
						'rules' => 'trim|required'
				),
				array (
						'field' => 'order_state',
						'label' => 'order_state',
						'rules' => 'trim|required'
				),
				
				array (
						'field' => 'customer_email_id',
						'label' => 'customer_email_id',
						'rules' => 'trim|required|valid_email'
				),
				array (
						'field' => 'drop_of_datetime',
						'label' => 'drop_of_datetime',
						'rules' => 'trim|required'
				),
				array (
						'field' => 'pick_up_datetime',
						'label' => 'pick_up_datetime',
						'rules' => 'trim|required'
				)
		),
		'bulk_email' => array (
				array (
						'field' => 'customername',
						'label' => 'customername',
						'rules' => 'trim|required'
				),
				array (
						'field' => 'customeremail',
						'label' => 'customeremail',
						'rules' => 'trim|required'
				),
				array (
						'field' => 'customerphone',
						'label' => 'customerphone',
						'rules' => 'trim|required'
				),
				array (
						'field' => 'emailSubject',
						'label' => 'emailSubject',
						'rules' => 'trim|required'
				),
				array (
						'field' => 'emailBody',
						'label' => 'emailBody',
						'rules' => 'trim|required'
				)
		)
		
		
);
