<?php
require APPPATH . 'libraries/REST_Controller.php';

class Payment extends REST_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->helper('url', 'form');
		$this->load->library('session');
		$this->load->database();
		$this->load->model('api/Payment_model', 'payment_model');
	}
	
	private function _generatePIN($digits = 8) {
		$i = 0; //counter
		$pin = ""; //our default pin is blank.
		while ($i < $digits) {
		//generate a random number between 0 and 9.
		$pin .= mt_rand(0, 9);
		$i++;
		}
		return $pin;
	}

	public function init_transaction_get(){
		try{
			$success	= 0;
			$curl 		= curl_init();
			$token 		= '2c1816316e65dbfcb0c34a25f3d6fe5589aef65d';
			$amount 	= trim($this->get('amount'));
			$txn_id 	= $this->_generatePIN();
			$event_id  	= trim($this->get('event_id'));
			$user_id	= trim($this->get('user_id'));
			$digest 	= sha1($amount . $txn_id . $token);

			if(EMPTY($amount))
				throw new Exception("Amount is required.");

			if(EMPTY($event_id))
				throw new Exception("Event ID is required.");

			if(EMPTY($user_id))
				throw new Exception("User ID is required.");

			if(EMPTY($txn_id))
				throw new Exception("TXN ID is required.");

			if(EMPTY($digest))
				throw new Exception("Digest is required.");

			$trans_params = json_encode(array(
				"amount"  	=> $amount,
				"txnid" 	=> $txn_id,
				"digest" 	=> $digest
			));

			curl_setopt_array($curl, array(
			CURLOPT_URL => "https://pgi-ws-staging.bayadcenter.net/api/v1/transactions/generate",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => false,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => $trans_params,
			CURLOPT_HTTPHEADER => array(
				"X-BayadCenter-Token: " . $token,
				"X-BayadCenter-Code: MSYS_TEST_BILLER",
				"Content-Type: application/json"
			),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);
			
			if ($err)
				throw new Exception($err);
			
			$success  = 1;
		}catch (Exception $e){
			$msg = $e->getMessage();      
		}

		if($success == 0){
			$response = [
				'msg'       => $msg,
				'flag'      => $success
			];
		}

		$this->response($response);
	}

	public function search_transaction_get(){
		try{
			$success	= 0;
			$curl 		= curl_init();
			$ref_number = trim($this->get('ref_number'));
				
			if(EMPTY($ref_number))
				throw new Exception("Reference number is required.");
			
			curl_setopt_array($curl, array(
			CURLOPT_URL => "https://pgi-ws-staging.bayadcenter.net/api/v1/transactions/" . $ref_number,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => false,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"X-BayadCenter-Token: 2c1816316e65dbfcb0c34a25f3d6fe5589aef65d",
				"X-BayadCenter-Code: MSYS_TEST_BILLER"
			),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);
			
			if ($err)
				throw new Exception($err);
			
			$success  = 1;
		}catch (Exception $e){
			$msg = $e->getMessage();      
		}

		if($success == 0){
			$response = [
				'msg'       => $msg,
				'flag'      => $success
			];
		}

		$this->response(json_decode($response));
	}

	public function add_payment_post(){
		try{
			$success  = 0;
			$msg = array();
			$payment_params = array(
				'payment_ref_number'	=> trim($this->input->post('payment_ref_number')),
				'event_id'				=> trim($this->input->post('event_id')),
				'user_id'				=> trim($this->input->post('user_id'))
			);

			if(EMPTY($payment_params['payment_ref_number']))
				throw new Exception("Payment Reference Number is required.");
			
			if(EMPTY($payment_params['event_id']))
				throw new Exception("Event ID is required.");

			if(EMPTY($payment_params['user_id']))
				throw new Exception("User ID is required.");

			$this->payment_model->add_payment($payment_params);
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
