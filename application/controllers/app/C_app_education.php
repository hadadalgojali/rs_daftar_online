<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_app_education extends CI_Controller {
	protected $_ci;

	public function __construct(){
		parent::__construct();
		$this->_ci = &get_instance();
		$this->load->model('App_education');
	}

	public function index(){
		// $this->load->view('index', $response);
	}

	public function get($criteria = null){
		$this->App_education->set_database($this->load->database('default',TRUE));

		$result = $this->App_education->get("*", $this->input->get('params'), $this->input->get('limit'), $this->input->get('start'));
		echo json_encode(
			array(
				'results' => $result->result(),
				'total' 	=> $this->App_education->get(" COALESCE(count(*),0) as count ")->row()->count,
				'status'	=> 200,
			)
		);
	}

	public function save(){
		$response 	= array();
		$parameter 	= array(
			'id'				=> $this->input->post('id'),
			'education'			=> $this->input->post('education'),
			'active_flag'		=> $this->convert_bit_bool($this->input->post('active')),
		);

		$this->App_education->set_database($this->load->database('default',TRUE));
		$parameter['id'] = $this->App_education->get(" max(id) as id");
		if ($parameter['id']->num_rows() > 0) {
			$parameter['id'] = $parameter['id']->row()->id + 1;
		}

		$result = $this->App_education->create($parameter);
		if ($result['result'] > 0 || $result['result'] === true) {
			$response['status'] 	= 200;
			$response['message'] 	= "Create success";
		}else{
			$response['status'] 	= 401;
			$response['message'] 	= $query['error']['message'];
		}
		echo json_encode($response);
	}

	public function update(){
		$response 	= array();
		$criteria 	= array(
			'id'			=> $this->input->post('id'),
		);
		$parameter 	= array(
			'education'			=> $this->input->post('education'),
			'active_flag'		=> $this->convert_bit_bool($this->input->post('active')),
		);

		$this->App_education->set_database($this->load->database('default',TRUE));
		$result = $this->App_education->update($criteria, $parameter);
		if ($result['result'] > 0 || $result['result'] === true) {
			$response['status'] 	= 200;
			$response['message'] 	= "Update success";
		}else{
			$response['status'] 	= 401;
			$response['message'] 	= $result['error']['message'];
		}
		echo json_encode($response);
	}

	public function delete(){
		$response 			= array();
		$parameter = array(
			'id' 	=> $this->input->post('id')
		);

		$this->App_education->set_database($this->load->database('default',TRUE));
		if (count(json_decode($parameter['id'])) > 0) {
			foreach (json_decode($parameter['id']) as $key => $value) {
				$criteria 				= array();
				$criteria['id'] 	= $value;
				$result 	= $this->App_education->delete($criteria);
				if ($result['result'] === false || $result['result'] == 0) {
					break;
				}
			}
		}else{
			$criteria 				= array();
			$criteria['id'] 	= $parameter['id'];
			$result = $this->App_education->delete($criteria);
		}
		
		if ($result['result'] > 0 || $result['result'] === true) {
			$response['status'] 	= 200;
			$response['message'] 	= "Delete success";
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
