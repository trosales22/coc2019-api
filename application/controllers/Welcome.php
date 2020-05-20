<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	public function index(){
		$response = array(
			'msg'			=> 'Welcome to Clash Of Codes 2019 API!',
			'environment' 	=> ENVIRONMENT,
			'server_name'	=> $_SERVER['SERVER_NAME']
		);

		echo json_encode($response);
	}
}
