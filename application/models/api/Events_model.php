<?php
class Events_model extends CI_Model {
	public function get_events(array $event_params = NULL){
		$where_condition = '';

		if(!empty($event_params['event_id'])){
			$where_condition .= "AND A.event_id = " . $event_params['event_id'] . "";
		}

		if(!empty($event_params['event_name'])){
			$where_condition .= "AND A.event_name LIKE '%" . $event_params['event_name'] . "%'";
		}
		
		$query = "
			SELECT 
				A.event_id, A.event_name, A.event_details,
				IF( ISNULL(C.event_img), '', CONCAT('" . base_url() . "uploads/events/', C.event_img) ) as event_image,
				A.event_venue, A.event_schedule, A.event_fee,
				B.user_id, B.firstname, B.lastname, 
				DATE_FORMAT(A.created_date, '%M %d, %Y %r') as event_created_date
			FROM 
				events A
			LEFT JOIN 
				users B ON A.created_by = B.user_id 
			LEFT JOIN 
				event_images C ON A.event_id = C.event_id 
			WHERE 
				A.active_flag = 'Y' $where_condition
			";
		
		$stmt = $this->db->query($query);
		return $stmt->result();
	}

	public function add_event(array $data){
		try{
			//insert to events table
			$event_fields = array(
				'event_name' 		=> $data['event_name'],
				'event_details' 	=> $data['event_details'],
				'event_venue' 		=> $data['event_venue'],
				'event_schedule' 	=> $data['event_schedule'],
				'created_by' 		=> $data['created_by']
			);
			
			//insert to users table
			$this->db->insert('events', $event_fields);
			$lastInsertedId = $this->db->insert_id();

			//insert to event_images table
			$event_images_fields = array(
				'event_id' 		=> $lastInsertedId,
				'event_img'		=> $data['event_img']
			);

			$this->db->insert('event_images', $event_images_fields);
		}catch(PDOException $e){
			$msg = $e->getMessage();
			$this->db->trans_rollback();
		}
	}
}
