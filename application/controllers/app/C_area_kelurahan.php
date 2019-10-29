<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_area_kelurahan extends CI_Controller {
	protected $_ci;

	public function __construct(){
		parent::__construct();
		$this->_ci = &get_instance();
		$this->load->model('Area_kelurahan');
	}

	public function index(){
		// $this->load->view('index', $response);
	}

	public function get($criteria = null){
		$this->Area_kelurahan->set_database($this->load->database('default',TRUE));

		$result = $this->Area_kelurahan->get("*", $this->input->get('params'), $this->input->get('limit'), $this->input->get('start'));
		echo json_encode(
			array(
				'results' => $result->result(),
				'total' 	=> $this->Area_kelurahan->get(" COALESCE(count(*),0) as count ")->row()->count,
				'status'	=> 200,
			)
		);
	}

	public function save(){
		$response 	= array();
		$parameter 	= array(
			'country_name' 		=> $this->input->post('country_name'),
			'active_flag'		=> $this->convert_bit_bool($this->input->post('active')),
		);

		$this->Area_kelurahan->set_database($this->load->database('default',TRUE));
		$parameter['country_id'] = $this->Area_kelurahan->get(" max(country_id) as id");
		if ($parameter['country_id']->num_rows() > 0) {
			$parameter['country_id'] = $parameter['country_id']->row()->id + 1;
		}

		$result = $this->Area_kelurahan->create($parameter);
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
			'country_id'		=> $this->input->post('id'),
		);
		$parameter 	= array(
			'country_name'		=> $this->input->post('country_name'),
			'active_flag'		=> $this->convert_bit_bool($this->input->post('active')),
		);

		$this->Area_kelurahan->set_database($this->load->database('default',TRUE));
		$result = $this->Area_kelurahan->update($criteria, $parameter);
		if ($result['result'] > 0 || $result['result'] === true) {
			$response['status'] 	= 200;
			$response['message'] 	= "Update success";
		}else{
			if ($result['error']['message'] == "") {
				$response['status'] 	= 200;
				$response['message'] 	= "Update success";
			}else{
				$response['status'] 	= 401;
				$response['message'] 	= $result['error']['message'];
			}
		}
		echo json_encode($response);
	}

	public function delete(){
		$response 			= array();
		$parameter = array(
			'id' 	=> $this->input->post('id')
		);

		$this->Area_kelurahan->set_database($this->load->database('default',TRUE));
		if (count(json_decode($parameter['id'])) > 0) {
			foreach (json_decode($parameter['id']) as $key => $value) {
				$criteria 				= array();
				$criteria['country_id'] 	= $value;
				$result 	= $this->Area_kelurahan->delete($criteria);
				if ($result['result'] === false || $result['result'] == 0) {
					break;
				}
			}
		}else{
			$criteria 				= array();
			$criteria['country_id'] 	= $parameter['id'];
			$result = $this->Area_kelurahan->delete($criteria);
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
