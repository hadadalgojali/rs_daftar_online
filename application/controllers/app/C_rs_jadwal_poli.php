<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_rs_jadwal_poli extends CI_Controller {
	protected $_ci;

	public function __construct(){
		parent::__construct();
		$this->_ci = &get_instance();
		$this->load->model('Rs_jadwal_poli');
	}

	public function index(){
		// $this->load->view('index', $response);
	}

	public function get($criteria = null){
		$this->Rs_jadwal_poli->set_database($this->load->database('default',TRUE));

		$result = $this->Rs_jadwal_poli->get_with_join("rs_jadwal_poli.*, app_employee.first_name, rs_unit.unit_name", $this->input->get('params'), $this->input->get('limit'), $this->input->get('start'));
		echo json_encode(
			array(
				'results' 	=> $result->result(),
				'total' 	=> $this->Rs_jadwal_poli->get_with_join(" COALESCE(count(*),0) as count ", $this->input->get('params'))->row()->count,
				'status'	=> 200,
			)
		);
	}

	public function save(){
		$response 	= array();
		$parameter 	= array(
			// 'unit_id'			=> $this->input->post('id'),
			'unit_id'			=> $this->input->post('unit_id'),
			'dokter_id'			=> $this->input->post('employee_id'),
			'hari'				=> $this->input->post('day'),
			'start'				=> date_format(date_create($this->input->post('start')), "H:i:s"),
			'end'				=> date_format(date_create($this->input->post('end')), "H:i:s"),
			'max_pelayanan'		=> $this->input->post('max'),
			'durasi_periksa'	=> $this->input->post('duration'),
			'active_flag'		=> $this->convert_bit_bool($this->input->post('active')),
		);

		$this->Rs_jadwal_poli->set_database($this->load->database('default',TRUE));
		$parameter['id_jadwal_poli'] = $this->Rs_jadwal_poli->get(" max(id_jadwal_poli) as id");
		if ($parameter['id_jadwal_poli']->num_rows() > 0) {
			$parameter['id_jadwal_poli'] = $parameter['id_jadwal_poli']->row()->id + 1;
		}

		$result = $this->Rs_jadwal_poli->create($parameter);
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
			'id_jadwal_poli'	=> $this->input->post('id'),
		);
		$parameter 	= array(
			'unit_id'			=> $this->input->post('unit_id'),
			'dokter_id'			=> $this->input->post('employee_id'),
			'hari'				=> $this->input->post('day'),
			'start'				=> date_format(date_create($this->input->post('start')), "H:i:s"),
			'end'				=> date_format(date_create($this->input->post('end')), "H:i:s"),
			'durasi_periksa'	=> $this->input->post('duration'),
			'max_pelayanan'		=> $this->input->post('max'),
			'active_flag'		=> $this->convert_bit_bool($this->input->post('active')),
		);

		$this->Rs_jadwal_poli->set_database($this->load->database('default',TRUE));
		$result = $this->Rs_jadwal_poli->update($criteria, $parameter);
		if ($result['result'] > 0 || $result['result'] === true) {
			$response['status'] 	= 200;
			$response['message'] 	= "Update customer success";
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

		$this->Rs_jadwal_poli->set_database($this->load->database('default',TRUE));
		if (count(json_decode($parameter['id'])) > 0) {
			foreach (json_decode($parameter['id']) as $key => $value) {
				$criteria 						= array();
				$criteria['id_jadwal_poli'] 	= $value;
				$result 	= $this->Rs_jadwal_poli->delete($criteria);
				if ($result['result'] === false || $result['result'] == 0) {
					break;
				}
			}
		}else{
			$criteria 						= array();
			$criteria['id_jadwal_poli'] 	= $parameter['id'];
			$result = $this->Rs_jadwal_poli->delete($criteria);
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
