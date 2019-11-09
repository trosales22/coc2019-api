<?php
require APPPATH . 'libraries/REST_Controller.php';

class Announcements extends REST_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->model('api/Announcements_model', 'announcements_model');
	}
}
