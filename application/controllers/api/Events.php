<?php
require APPPATH . 'libraries/REST_Controller.php';

class Events extends REST_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->helper('url', 'form');
		$this->load->library('session');
		$this->load->database();
		$this->load->model('api/Events_model', 'events_model');
	}

	public function get_events_get(){
		try{
			$success        		= 0;
			$event_name 	= trim($this->get('event_name'));

			$event_params = array(
				'event_name' => $event_name
			);
			
			$events_list = $this->events_model->get_events($event_params);
			$success  = 1;
		}catch (Exception $e){
			$msg = $e->getMessage();      
		}

		if($success == 1){
			$response = [
			  'events_list' => $events_list
			];
		}else{
			$response = [
				'msg'       => $msg,
				'flag'      => $success
			];
		}
	  
		$this->response($response);
	}
	
	public function add_event_post(){
		try{
			$success  = 0;
			$msg = array();
			$event_image_output = array();

			$event_fields =   array(
				'event_name'     	=> trim($this->input->post('event_name')),
				'event_details'     => trim($this->input->post('event_details')),
				'event_venue'   	=> trim($this->input->post('event_venue')),
				'event_schedule'    => trim($this->input->post('event_schedule')),
				'created_by'       	=> trim($this->input->post('created_by'))
			);

			if(EMPTY($event_fields['event_name']))
				throw new Exception("Event Name is required.");

			if(EMPTY($event_fields['event_details']))
				throw new Exception("Event Details is required.");

			if(EMPTY($event_fields['event_venue']))
				throw new Exception("Event Venue is required.");

			if(EMPTY($event_fields['event_schedule']))
				throw new Exception("Event Schedule is required.");

			if(EMPTY($event_fields['created_by']))
				throw new Exception("Creator is required.");
			
			$config['upload_path'] = 'uploads/events/';
			$config['allowed_types'] = 'jpg|jpeg|png';
			$config['max_size'] = 5000;
			$config['max_width'] = 1500;
			$config['max_height'] = 1500;
			$config['file_name'] = md5(time() . rand()) . '_' . mt_rand();

			$this->load->library('upload', $config);
			
			//validate company id
			if(!$this->upload->do_upload('event_img')) {
				$msg = array(
					'status'	=> 'FAILED',
					'error'	 	=> $this->upload->display_errors()
				);
			}else{
				$upload_img_output = array(
					'image_metadata' => $this->upload->data()
				);

				$event_image_output = array(
					'event_img'	=> $upload_img_output['image_metadata']['file_name']
				);
			}

			$event_fields['event_img'] = $event_image_output['event_img'];

			if(EMPTY($event_fields['event_img']))
				throw new Exception("Event Image is required.");

			$this->events_model->add_event($event_fields);
			$success  = 1;
		}catch (Exception $e){
			$msg = $e->getMessage();      
		}

		if($success == 1){
			$response = [
				'msg'       => 'Event was successfully added!',
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
