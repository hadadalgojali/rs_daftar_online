<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_app_user extends CI_Controller {
	protected $_ci;

	public function __construct(){
		parent::__construct();
		$this->_ci = &get_instance();
		$this->load->model('App_user');
	}

	public function index(){
		// $this->load->view('index', $response);
	}

	public function get($criteria = null){
		$this->App_user->set_database($this->load->database('default',TRUE));

		$App_user = $this->App_user->get_with_employee("*", $this->input->get('params'),$this->input->get('limit'),$this->input->get('start'));
		echo json_encode(
			array(
				'results' 	=> $App_user->result(),
				'total' 	=> $App_user->num_rows(),
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

		$this->App_user->set_database($this->load->database('default',TRUE));
		$parameter['role_id'] = $this->App_user->get(" max(role_id) as role_id");
		if ($parameter['role_id']->num_rows() > 0) {
			$parameter['role_id'] = $parameter['role_id']->row()->role_id + 1;
		}

		$result = $this->App_user->create($parameter);
		if ($result > 0 || $result === true) {
			$response['message'] 	= "Berhasil disimpan";
			$response['status'] 	= 200;
		}else{
			$response['message'] 	= "Gagal disimpan";
			$response['status'] = 401;
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

		$this->App_user->set_database($this->load->database('default',TRUE));
		$result = $this->App_user->update($criteria, $parameter);
		if ($result > 0 || $result === true) {
			$response['message'] 	= "Berhasil disimpan";
			$response['status'] 	= 200;
		}else{
			$response['message'] 	= "Gagal disimpan";
			$response['status'] 	= 401;
		}
		echo json_encode($response);
	}

	public function delete(){
		$response 			= array();
		$response['status'] = false;
		$parameter = array(
			'id' 	=> $this->input->post('id')
		);
		
		$this->App_user->set_database($this->load->database('default',TRUE));
		if (count(json_decode($parameter['id'])) > 0) {
			foreach (json_decode($parameter['id']) as $key => $value) {
				$criteria 				= array();
				$criteria['role_id'] 	= $value;
				$response['status'] 	= $this->App_user->delete($criteria);
				if ($response['status'] === false || $response['status'] == 0) {
					break;
				}
			}
		}else{
			$criteria 				= array();
			$criteria['role_id'] 	= $parameter['id'];
			$response['status'] 	= $this->App_user->delete($criteria);
		}


		if ($response['status']>0 || $response['status']===true) {
			$response['message'] = "Data di hapus";
			$response['status']  = 200;
		}else{
			$response['message'] = "Data gagal di hapus";
			$response['status'] = 401;

		}
		echo json_encode($response);
	}
}
