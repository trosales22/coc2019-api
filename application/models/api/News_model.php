<?php
class News_model extends CI_Model {
	public function get_news(array $news_params){
		$where_condition = '';

		if(!empty($news_params['news_id'])){
			$where_condition .= "AND A.news_id = " . $news_params['news_id'] . "";
		}
		
		if(!empty($news_params['news_caption'])){
			$where_condition .= "AND A.news_caption LIKE '%" . $news_params['news_caption'] . "%'";
		}
		
		$query = "
			SELECT 
				A.news_id, A.news_caption, A.news_url,
				B.user_id, B.firstname, B.lastname, 
				DATE_FORMAT(A.created_date, '%M %d, %Y %r') as news_created_date
			FROM 
				news A
			LEFT JOIN 
				users B ON A.created_by = B.user_id 
			WHERE 
				A.active_flag = 'Y' $where_condition
			";
		
		$stmt = $this->db->query($query);
		return $stmt->result();
	}

	public function add_news(array $data){
		try{
			$news_fields = array(
				'news_caption' 	=> $data['news_caption'],
				'news_url' 		=> $data['news_url'],
				'created_by' 	=> $data['created_by']
			);
			
			$this->db->insert('news', $news_fields);
			$lastInsertedId = $this->db->insert_id();
		}catch(PDOException $e){
			$msg = $e->getMessage();
			$this->db->trans_rollback();
		}
	}
}
