<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_rs_customer extends CI_Controller {
	protected $_ci;

	public function __construct(){
		parent::__construct();
		$this->_ci = &get_instance();
		$this->load->model('Rs_customer');
	}

	public function index(){
		// $this->load->view('index', $response);
	}

	public function get($criteria = null){
		$this->Rs_customer->set_database($this->load->database('default',TRUE));

		$Rs_customer = $this->Rs_customer->get("*", $this->input->get('params'), $this->input->get('limit'), $this->input->get('start'));
		echo json_encode(
			array(
				'results' 	=> $Rs_customer->result(),
				'total' 	=> $Rs_customer->num_rows(),
				'status'	=> 200,
			)
		);
	}

	public function save(){
		$response 	= array();
		$parameter 	= array(
			'customer_id'			=> $this->input->post('id'),
			'customer_name'		=> $this->input->post('name'),
			'customer_code'		=> $this->input->post('code'),
			'active_flag'			=> $this->convert_bit_bool($this->input->post('active')),
		);

		$this->Rs_customer->set_database($this->load->database('default',TRUE));
		$parameter['customer_id'] = $this->Rs_customer->get(" max(customer_id) as id");
		if ($parameter['customer_id']->num_rows() > 0) {
			$parameter['customer_id'] = $parameter['customer_id']->row()->id + 1;
		}

		$result = $this->Rs_customer->create($parameter);
		if ($result['result'] > 0 || $result['result'] === true) {
			$response['status'] 	= 200;
			$response['message'] 	= "Create customer success";
		}else{
			$response['status'] 	= 401;
			$response['message'] 	= $query['error']['message'];
		}
		echo json_encode($response);
	}

	public function update(){
		$response 	= array();
		$criteria 	= array(
			'customer_id'			=> $this->input->post('id'),
		);
		$parameter 	= array(
			'customer_name'		=> $this->input->post('name'),
			'customer_code'		=> $this->input->post('code'),
			'active_flag'			=> $this->convert_bit_bool($this->input->post('active')),
		);

		$this->Rs_customer->set_database($this->load->database('default',TRUE));
		$result = $this->Rs_customer->update($criteria, $parameter);
		if ($result['result'] > 0 || $result['result'] === true) {
			$response['status'] 	= 200;
			$response['message'] 	= "Update customer success";
		}else{
			$response['status'] 	= 401;
			$response['message'] 	= $query['error']['message'];
		}
		echo json_encode($response);
	}

	public function delete(){
		$response 			= array();
		$parameter = array(
			'id' 	=> $this->input->post('id')
		);

		$this->Rs_customer->set_database($this->load->database('default',TRUE));
		if (count(json_decode($parameter['id'])) > 0) {
			foreach (json_decode($parameter['id']) as $key => $value) {
				$criteria 				= array();
				$criteria['customer_id'] 	= $value;
				$result 	= $this->Rs_customer->delete($criteria);
				if ($result['result'] === false || $result['result'] == 0) {
					break;
				}
			}
		}else{
			$criteria 				= array();
			$criteria['customer_id'] 	= $parameter['id'];
			$result = $this->Rs_customer->delete($criteria);
		}

		if ($result['result'] > 0 || $result['result'] === true) {
			$response['status'] 	= 200;
			$response['message'] 	= "Delete customer success";
		}else{
			$response['status'] 	= 401;
			$response['message'] 	= $result['error']['message'];
		}
		echo json_encode($response);
	}

		private function convert_bit_bool($parameter){
			if (is_numeric($parameter) === true) {
				if ($parameter == 1 || $parameter == '1') {
					return 'true';
				}else{
					return 'false';
				}
			}else{
				if ($parameter === 'true' || $parameter === true) {
					return 1;
				}else if($parameter === 'false' || $parameter === false){
					return 0;
				}else if ($parameter == 1 || $parameter == '1') {
					return 'true';
				}else{
					return 'false';
				}
			}
		}
}
