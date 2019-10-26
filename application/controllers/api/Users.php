<?php
header('Access-Control-Allow-Origin: *');
require APPPATH . 'libraries/REST_Controller.php';
     
class Users extends REST_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->model('api/Users_model', 'users_model');
	}
	
	public function user_login_post() {
		$inputs = array(
			'username_or_email' => $this->post('username_or_email'),
			'password' 			=> $this->post('password')
		);

		$res = array();
		$result = $this->users_model->get_user_information($inputs['username_or_email']);

		if(empty($result)){
			$res = array(
				'status' 	=> 'UNKNOWN_USER',
				'msg'		=> 'User not found!'
			);
		}else{
			if(password_verify($inputs['password'], $result[0]->password)){
				$fields = array(
					'username_or_email' => $inputs['username_or_email'],
					'password' 			=> $result[0]->password
				);
				
				$count = $this->users_model->login_user($fields);
	
				if($count == 1){
					$user_role_res = $this->users_model->get_user_role($result[0]->user_id);
					
					if($user_role_res[0]->role_code == 'SUPER_ADMIN'){
						$res = array(
							'status' => 'INVALID_ROLE', 
							'msg' => 'Super Admin is not allowed to login!'
						);
					}else{
						$session_data = array(
							'status'		=> 'OK',
							'user_id'		=> $result[0]->user_id,
							'username' 		=> $result[0]->username,
							'email' 		=> $result[0]->email,
							'role_code'		=> $result[0]->role_code
						);
						
						$res = $session_data;
					}
				}else{
					$res = array(
						'status' 	=> 'INVALID_LOGIN',
						'msg'		=> 'Invalid username or password!'
					);
				}
			}else{
				$res = array(
					'status' 	=> 'PASSWORD_MISMATCH',
					'msg'		=> 'Password does not match!'
				);
			}
		}

		$this->response($res);
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
}
