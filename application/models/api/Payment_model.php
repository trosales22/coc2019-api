<?php
class Payment_model extends CI_Model {
	public function get_payments(array $payment_params = NULL){
		$where_condition = '';

		if(!empty($payment_params['payment_id'])){
			$where_condition .= "AND A.payment_id = " . $payment_params['payment_id'] . "";
		}

		if(!empty($payment_params['payment_ref_number'])){
			$where_condition .= "AND A.payment_ref_number LIKE '%" . $payment_params['payment_ref_number'] . "%'";
		}

		if(!empty($payment_params['event_id'])){
			$where_condition .= "AND A.event_id LIKE '%" . $payment_params['event_id'] . "%'";
		}
		
		if(!empty($payment_params['user_id'])){
			$where_condition .= "AND A.user_id LIKE '%" . $payment_params['user_id'] . "%'";
		}
		
		$query = "
			SELECT 
				A.payment_id, A.payment_ref_number, 
				A.event_id, C.event_name,
				A.user_id, CONCAT(B.firstname, ' ', B.lastname) as fullname, 
				DATE_FORMAT(A.created_date, '%M %d, %Y %r') as payment_created_date
			FROM 
				payments A
			LEFT JOIN 
				users B ON A.user_id = B.user_id 
			LEFT JOIN 
				events C ON A.event_id = C.event_id 
			WHERE 
				A.active_flag = 'Y' $where_condition
			";
		
		$stmt = $this->db->query($query);
		return $stmt->result();
	}
	
	public function add_payment(array $data){
		try{
			$payment_fields = array(
				'payment_ref_number' 	=> $data['payment_ref_number'],
				'event_id' 				=> $data['event_id'],
				'user_id' 				=> $data['user_id']
			);
			
			$this->db->insert('payments', $payment_fields);
			$lastInsertedId = $this->db->insert_id();
		}catch(PDOException $e){
			$msg = $e->getMessage();
			$this->db->trans_rollback();
		}
	}
}
