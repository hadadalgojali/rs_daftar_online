<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_app_role extends CI_Controller {
	protected $_ci;

	public function __construct(){
		parent::__construct();
		$this->_ci = &get_instance();
		$this->load->model('App_role');
	}

	public function index(){
		// $this->load->view('index', $response);
	}

	public function get($criteria = null){
		$this->App_role->set_database($this->load->database('default',TRUE));

		$App_role = $this->App_role->get("*", $this->input->get('params'),$this->input->get('limit'),$this->input->get('start'));
		echo json_encode(
			array(
				'results' 	=> $App_role->result(),
				'total' 	=> $App_role->num_rows(),
				'status'	=> 200,
			)
		);
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

	public function save(){
		$response 	= array();
		$parameter 	= array(
			'role_id'		=> $this->input->post('id'),
			'role_code' 	=> $this->input->post('role_code'),
			'role_name' 	=> $this->input->post('role_name'),
			'description' 	=> $this->input->post('description'),
			'role_id' 		=> $this->session->userdata('role_id'),
			'create_on' 	=> date('Y-m-d'),
			'tenant_id' 	=> $this->input->post('tenant_id'),
			'active_flag' => $this->convert_bit_bool($this->input->post('active')),
			'create_by' 	=> $this->session->userdata('role_id'),
			'update_on' 	=> date('Y-m-d'),
			'update_by' 	=> $this->session->userdata('role_id'),

		);

		$this->App_role->set_database($this->load->database('default',TRUE));
		$parameter['role_id'] = $this->App_role->get(" max(role_id) as role_id");
		if ($parameter['role_id']->num_rows() > 0) {
			$parameter['role_id'] = $parameter['role_id']->row()->role_id + 1;
		}

		$result = $this->App_role->create($parameter);
		if ($result['result'] > 0 || $result['result'] === true) {
			$response['message'] 	= "Berhasil disimpan";
			$response['status'] 	= 200;
		}else{
			$response['message'] 	= $result['error']['message'];
			$response['status'] 	= $result['error']['code'];
		}
		echo json_encode($response);
	}

	public function update(){
		$response 	= array();
		$criteria 	= array(
			'role_id'		=> $this->input->post('id'),
		);
		$parameter 	= array(
			'role_code' 	=> $this->input->post('role_code'),
			'role_name' 	=> $this->input->post('role_name'),
			'description' 	=> $this->input->post('description'),
			'update_on' 	=> date('Y-m-d'),
			'update_by' 	=> $this->session->userdata('role_id'),
			'tenant_id' 	=> $this->input->post('tenant_id'),
			'active_flag' => $this->convert_bit_bool($this->input->post('active')),
		);

		$this->App_role->set_database($this->load->database('default',TRUE));
		$result = $this->App_role->update($criteria, $parameter);
		if ($result['result'] > 0 || $result['result'] === true) {
			$response['message'] 	= "Update success";
			$response['status'] 	= 200;
		}else{
			if ($result['error']['code'] > 0) {
				$response['message'] 	= $result['error']['message'];
				$response['status'] 	= $result['error']['code'];
			}else{
				$response['message'] 	= "Update success";
				$response['status'] 	= 200;
			}
		}
		echo json_encode($response);
	}

	public function delete(){
		$response 			= array();
		$result 				= array();
		$parameter = array(
			'id' 	=> $this->input->post('id')
		);

		$this->App_role->set_database($this->load->database('default',TRUE));
		if (count(json_decode($parameter['id'])) > 0) {
			foreach (json_decode($parameter['id']) as $key => $value) {
				$criteria 				= array();
				$criteria['role_id'] 	= $value;
				$result 	= $this->App_role->delete($criteria);
				if ($result['result'] === false || $result['result'] == 0) {
					break;
				}
			}
		}else{
			$criteria 						= array();
			$criteria['role_id'] 	= $parameter['id'];
			$result 							= $this->App_role->delete($criteria);
		}


		if ($result['result'] > 0 || $result['result'] === true) {
			$response['message'] 	= "Berhasil disimpan";
			$response['status'] 	= 200;
		}else{
			$response['message'] 	= $result['error']['message'];
			$response['status'] 	= $result['error']['code'];
		}
		echo json_encode($response);
	}
}
