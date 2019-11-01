<?php
class Users_model extends CI_Model {

	private function _generate_pin($digits = 4) {
		$i = 0; //counter
		$pin = ""; //our default pin is blank.
		while ($i < $digits) {
		  //generate a random number between 0 and 9.
		  $pin .= mt_rand(0, 9);
		  $i++;
		}
		return $pin;
	}

	public function login_user(array $data){
		$params = array(
					$data['username_or_email'],
					$data['username_or_email'],
					$data['password'], 
					'Y'
				);
		$query = "
			SELECT 
				username
			FROM 
				users
			WHERE 
				username = ? OR email = ? AND password = ? AND active_flag = ?";
				
		$stmt = $this->db->query($query, $params);
		return $stmt->num_rows();
	}

	public function get_user_information($username_or_email){
		$params = array($username_or_email, $username_or_email, 'Y');
		$query = "
			SELECT 
				A.user_id, A.username, A.firstname, A.lastname, 
				A.email,A.gender, A.password, B.role_code, C.role_name
			FROM 
				users A
			LEFT JOIN 
				user_roles B ON A.user_id = B.user_id 
			LEFT JOIN 
				param_roles C ON B.role_code = C.role_code 
			WHERE 
				A.username = ? OR A.email = ? AND A.active_flag = ?
			";

		$stmt = $this->db->query($query, $params);
		return $stmt->result();
	}

	public function get_user_role($user_id){
		$params = array($user_id);
		$query = "
			SELECT 
				user_id,role_code
			FROM 
				user_roles
			WHERE 
				user_id = ?";

		$stmt = $this->db->query($query, $params);
		return $stmt->result();
	}

	public function register_customer(array $customer_params){
		$customer_fields = array(
			'username'			=> $customer_params['username'],
			'firstname' 		=> $customer_params['firstname'],
			'lastname' 			=> $customer_params['lastname'],
			'email' 			=> $customer_params['email'],
			'contact_number' 	=> $customer_params['contact_number'],
			'gender' 			=> $customer_params['gender'],
			'password' 			=> password_hash($customer_params['password'], PASSWORD_BCRYPT),
		);
		
		$this->db->insert('users', $customer_fields);
		$lastInsertedId = $this->db->insert_id();
		
		$user_role_fields = array(
			'user_id'	=> $lastInsertedId,
			'role_code'	=> 'CUSTOMER'
		);

		$this->db->insert('user_roles', $user_role_fields);
	}
}
