<?php
require APPPATH . 'libraries/REST_Controller.php';

class Users extends REST_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->model('api/Users_model', 'users_model');
	}
	
	public function login_customer_post() {
		try{
			$success       	= 0;
			$res 			= array();
			$username_email = trim($this->post('username_or_email'));
			$password 		= trim($this->post('password'));
			
			$inputs = array(
				'username_or_email' => $username_email,
				'password' 			=> $password
			);

			if(EMPTY($username_email))
				throw new Exception("Username or email is required.");

			if(EMPTY($password))
				throw new Exception("Password is required.");

			$result = $this->users_model->get_user_information($inputs['username_or_email']);

			if(empty($result)){
				throw new Exception("User not found!");
			}else{
				if(password_verify($inputs['password'], $result[0]->password)){
					$fields = array(
						'username_or_email' => $inputs['username_or_email'],
						'password' 			=> $result[0]->password
					);
					
					$count = $this->users_model->login_user($fields);
		
					if($count == 1){
						$user_role_res = $this->users_model->get_user_role($result[0]->user_id);
						
						$session_data = array(
							'user_id'		=> $result[0]->user_id,
							'username' 		=> $result[0]->username,
							'email' 		=> $result[0]->email,
							'role_code'		=> $result[0]->role_code,
							'role_caption'	=> $result[0]->role_name
						);
						
						$res = $session_data;

						// if($user_role_res[0]->role_code == 'SUPER_ADMIN'){
						// 	$res = array(
						// 		'status' => 'INVALID_ROLE', 
						// 		'msg' => 'Super Admin is not allowed to login!'
						// 	);
						// }else{
							
						// }
					}else{
						throw new Exception("Invalid username or password!");
					}
				}else{
					throw new Exception("Password does not match.");
				}
			}

			$success  = 1;
		}catch (Exception $e){
			$msg = $e->getMessage();      
		}

		if($success == 1){
			$response = [
				'msg'       	=> 'Customer logged in successfully.',
				'user_details' 	=> $res,
				'flag'			=> $success
			];
		}else{
			$response = [
				'msg'       => $msg,
				'flag'      => $success
			];
		}

		$this->response($response);
	}

	public function get_personal_info_get(){
		try{
			$success        		= 0;
			$username_email 	= $this->get('username_email');
			
			if(EMPTY($username_email))
        		throw new Exception("Username/email is required.");

			$personal_info = $this->users_model->get_user_information($username_email);
			$success  = 1;
		}catch (Exception $e){
			$msg = $e->getMessage();      
		}

		if($success == 1){
			if(empty($personal_info)){
				$response = [
					'msg'       => 'Unidentified user. Please try again.',
					'flag'		=> 0
				];
			}else{
				$response = $personal_info[0];
			}
		}else{
			$response = [
				'msg'       => $msg,
				'flag'      => $success
			];
		}
	  
		$this->response($response);
	}

	public function register_customer_post(){
		try{
			$success       	= 0;
			$username 		= trim($this->input->post('username'));
			$firstname 		= trim($this->input->post('firstname'));
			$lastname 		= trim($this->input->post('lastname'));
			$email 			= trim($this->input->post('email'));
			$contact_number = trim($this->input->post('contact_number'));
			$gender			= trim($this->input->post('gender'));
			$password 		= trim($this->input->post('password'));

			if(EMPTY($username))
				throw new Exception("Username is required.");

			if(EMPTY($firstname))
				throw new Exception("Firstname is required.");
			
			if(EMPTY($lastname))
				throw new Exception("Lastname is required.");

			if(EMPTY($email))
				throw new Exception("Email is required.");

			if(EMPTY($contact_number))
				throw new Exception("Contact Number is required.");

			if(EMPTY($gender))
				throw new Exception("Gender is required.");

			if(EMPTY($password))
				throw new Exception("Password is required.");

			$customer_fields =   array(
				'username'				=> $username,
				'firstname'     		=> $firstname,
				'lastname'       		=> $lastname,
				'email'       			=> $email,
				'contact_number'  		=> $contact_number,
				'gender'       			=> $gender,
				'password'				=> $password
			);
			
			$this->users_model->register_customer($customer_fields);
			$success  = 1;
		}catch (Exception $e){
			$msg = $e->getMessage();      
		}

		if($success == 1){
			$response = [
				'msg'       => 'Customer registered successfully.',
				'flag'		=> $success
			];
		}else{
			$response = [
				'msg'       => $msg,
				'flag'      => $success
			];
		}
		
		$this->response($response);
	}
}
