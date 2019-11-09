<?php
class Home_model extends CI_Model {
	public function getPersonalInfo($username_or_email){
		$params = array($username_or_email, $username_or_email, 'Y');
		$query = "
			SELECT 
				A.user_id, A.username, 
				A.firstname, A.lastname, A.email, 
				B.role_code, C.role_name
			FROM 
				users A
			LEFT JOIN 
				user_role B ON A.user_id = B.user_id 
			LEFT JOIN 
				param_roles C ON B.role_code = C.role_id 
			WHERE 
				A.username = ? OR A.email = ? AND A.active_flag = ?";

		$stmt = $this->db->query($query, $params);
		return $stmt->result();
	}
}
