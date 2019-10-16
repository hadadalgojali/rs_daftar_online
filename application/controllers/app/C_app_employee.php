<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_app_employee extends CI_Controller {
	protected $_ci;

	public function __construct(){
		parent::__construct();
		$this->_ci = &get_instance();
		$this->load->model('App_employee');
	}

	public function index(){
		// $this->load->view('index', $response);
	}

	public function get($criteria = null){
		$this->App_employee->set_database($this->load->database('default',TRUE));

		$App_employee = $this->App_employee->get_with_job(" app_job.job_name, app_employee.* ", $this->input->get('params'),$this->input->get('limit'),$this->input->get('start'));
		echo json_encode(
			array(
				'results' 	=> $App_employee->result(),
				'total' 	=> $App_employee->num_rows(),
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
			'id_number'     => $this->input->post('id_number'),
			'first_name'    => $this->input->post('first_name'),
			'last_name'   	=> $this->input->post('last_name'),
			'gender'        => $this->convert_bit_bool($this->input->post('gender')),
			'religion'      => $this->input->post('religion'),
			'birth_place'   => $this->input->post('birth_place'),
			'birth_date'    => $this->input->post('birth_date'),
			'address'       => $this->input->post('address'),
			'email_address' => $this->input->post('email'),
			'phone_number1' => $this->input->post('phone_1'),
			'phone_number2' => $this->input->post('phone_2'),
			'fax_number1'   => $this->input->post('fax'),
			'job_id'        => $this->input->post('job_id'),
			'create_on' 	=> date("Y-m-d"),
			'active_flag'   => $this->convert_bit_bool($this->input->post('active')),
		);

		$this->App_employee->set_database($this->load->database('default',TRUE));
		$parameter['employee_id'] = $this->App_employee->get(" max(employee_id) as id");
		if ($parameter['employee_id']->num_rows() > 0) {
			$parameter['employee_id'] = $parameter['employee_id']->row()->id + 1;
		}

		$result = $this->App_employee->create($parameter);
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
			'employee_id'	=> $this->input->post('employee_id'),
		);
		$parameter 	= array(
			'id_number'     => $this->input->post('id_number'),
			'first_name'    => $this->input->post('first_name'),
			'last_name'   	=> $this->input->post('last_name'),
			'gender'        => $this->convert_bit_bool($this->input->post('gender')),
			'religion'      => $this->input->post('religion'),
			'birth_place'   => $this->input->post('birth_place'),
			'birth_date'    => $this->input->post('birth_date'),
			'address'       => $this->input->post('address'),
			'email_address' => $this->input->post('email'),
			'phone_number1' => $this->input->post('phone_1'),
			'phone_number2' => $this->input->post('phone_2'),
			'fax_number1'   => $this->input->post('fax'),
			'job_id'        => $this->input->post('job_id'),
			'create_on' 	=> date("Y-m-d"),
			'active_flag'   => $this->convert_bit_bool($this->input->post('active')),
		);

		$this->App_employee->set_database($this->load->database('default',TRUE));
		$result = $this->App_employee->update($criteria, $parameter);
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
		
		$this->App_employee->set_database($this->load->database('default',TRUE));
		if (count(json_decode($parameter['id'])) > 0) {
			foreach (json_decode($parameter['id']) as $key => $value) {
				$criteria 					= array();
				$criteria['employee_id'] 	= $value;
				$response['status'] 		= $this->App_employee->delete($criteria);
				if ($response['status'] === false || $response['status'] == 0) {
					break;
				}
			}
		}else{
			$criteria 				= array();
			$criteria['employee_id'] 	= $parameter['id'];
			$response['status'] 	= $this->App_employee->delete($criteria);
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
