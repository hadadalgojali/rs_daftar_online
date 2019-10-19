<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_rs_visit extends CI_Controller {
	protected $_ci;

	public function __construct(){
		parent::__construct();
		$this->_ci = &get_instance();
		$this->load->model('Rs_visit');
	}

	public function index(){
		// $this->load->view('index', $response);
	}

	public function get($criteria = null){
		$this->Rs_visit->set_database($this->load->database('default',TRUE));

		$Rs_visit = $this->Rs_visit->get_with_relation("*", " rs_visit.entry_date = '".date("Y-m-d")."' ".$this->input->get('params'), $this->input->get('limit'), $this->input->get('start'));
		echo json_encode(
			array(
				'results' 	=> $Rs_visit->result(),
				'total' 	=> $Rs_visit->num_rows(),
				'status'	=> 200,
			)
		);
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
			'tenant_id' 	=> 1,
			'active_flag' 	=> 1,
			'create_by' 	=> $this->session->userdata('role_id'),
			'update_on' 	=> date('Y-m-d'),
			'update_by' 	=> $this->session->userdata('role_id'),

		);

		$this->Rs_visit->set_database($this->load->database('default',TRUE));
		$parameter['role_id'] = $this->Rs_visit->get(" max(role_id) as role_id");
		if ($parameter['role_id']->num_rows() > 0) {
			$parameter['role_id'] = $parameter['role_id']->row()->role_id + 1;
		}

		$result = $this->Rs_visit->create($parameter);
		if ($result['result'] > 0 || $result['result'] === true) {
			$response['status'] 	= 200;
			$response['message'] 	= "Update user account success";
		}else{
			$response['status'] 	= 401;
			$response['message'] 	= $query['error']['message'];
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
		);

		$this->Rs_visit->set_database($this->load->database('default',TRUE));
		$result = $this->Rs_visit->update($criteria, $parameter);
		if ($result['result'] > 0 || $result['result'] === true) {
			$response['status'] 	= 200;
			$response['message'] 	= "Update user account success";
		}else{
			$response['status'] 	= 401;
			$response['message'] 	= $query['error']['message'];
		}
		echo json_encode($response);
	}

	public function delete(){
		$response 			= array();
		$response['status'] = false;
		$parameter = array(
			'id' 	=> $this->input->post('id')
		);

		$this->Rs_visit->set_database($this->load->database('default',TRUE));
		if (count(json_decode($parameter['id'])) > 0) {
			foreach (json_decode($parameter['id']) as $key => $value) {
				$criteria 				= array();
				$criteria['visit_id'] 	= $value;
				$result 	= $this->Rs_visit->delete($criteria);
				if ($result['result'] === false || $result['result'] == 0) {
					break;
				}
			}
		}else{
			$criteria 				= array();
			$criteria['visit_id'] 	= $parameter['id'];
			$result = $this->Rs_visit->delete($criteria);
		}

		if ($result['result'] > 0 || $result['result'] === true) {
			$response['status'] 	= 200;
			$response['message'] 	= "Update user account success";
		}else{
			$response['status'] 	= 401;
			$response['message'] 	= $query['error']['message'];
		}
		echo json_encode($response);
	}
}
