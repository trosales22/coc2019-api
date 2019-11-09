<?php
require APPPATH . 'libraries/REST_Controller.php';

class News extends REST_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->model('api/News_model', 'news_model');
	}

	public function get_news_get(){
		try{
			$success        = 0;
			$news_id		= trim($this->get('news_id'));
			$news_caption 	= trim($this->get('news_caption'));

			$news_params = array(
				'news_id'		=> $news_id,
				'news_caption' 	=> $news_caption
			);
			
			$news_list = $this->news_model->get_news($news_params);
			$success  = 1;
		}catch (Exception $e){
			$msg = $e->getMessage();      
		}

		if($success == 1){
			$response = [
			  'news_list' => $news_list
			];
		}else{
			$response = [
				'msg'       => $msg,
				'flag'      => $success
			];
		}
	  
		$this->response($response);
	}

	public function add_news_post(){
		try{
			$success  = 0;
			$msg = array();
			$news_params = array(
				'news_caption'		=> trim($this->input->post('news_caption')),
				'news_url'			=> trim($this->input->post('news_url')),
				'created_by'		=> trim($this->input->post('created_by'))
			);

			if(EMPTY($news_params['news_url']))
				throw new Exception("News URL is required.");
			
			if(EMPTY($news_params['created_by']))
				throw new Exception("Creator is required.");

			$this->news_model->add_news($news_params);
			$success  = 1;
		}catch (Exception $e){
			$msg = $e->getMessage();      
		}

		if($success == 1){
			$response = [
				'msg'       => 'News was successfully added!',
				'flag'      => $success
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
