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

	public function get_user_information($username = NULL, $email = NULL){
		$params = array($username, $email, 'Y');
		$query = "
			SELECT 
				A.user_id, A.username, A.firstname, A.lastname, 
				A.email, A.gender, A.password, B.role_code, C.role_name
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
		try{
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
				'role_code'	=> 'HACKER'
			);

			$this->db->insert('user_roles', $user_role_fields);
		}catch(PDOException $e){
			$msg = $e->getMessage();
			$this->db->trans_rollback();
		}
	}

	public function get_hackers(){
		$params = array('HACKER');
		$query = "
			SELECT 
				A.user_id, A.username, A.email, A.contact_number, 
				CONCAT(A.firstname, ' ', A.lastname) as fullname,
				IF(A.gender = 'M', 'Male', 'Female') as gender,
				IF(A.active_flag = 'Y', 'ACTIVE', 'INACTIVE') as status,
				DATE_FORMAT(A.created_date, '%M %d, %Y %r') as date_registered
			FROM 
				users A
			LEFT JOIN 
				user_roles B ON A.user_id = B.user_id 
			WHERE B.role_code = ?";
		
		$stmt = $this->db->query($query, $params);
		return $stmt->result();
	}
}
