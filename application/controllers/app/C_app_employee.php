<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_app_employee extends CI_Controller {
	protected $_ci;

	public function __construct(){
		parent::__construct();
		$this->_ci = &get_instance();
		$this->load->model('App_employee');
		$this->load->model('App_user');
	}

	public function index(){
		// $this->load->view('index', $response);
	}

	public function get($criteria = null){
		$this->App_employee->set_database($this->load->database('default',TRUE));

		$App_employee = $this->App_employee->get_with_join(" app_job.job_name, app_employee.*, app_user.user_code, app_role.role_id, app_role.role_name, app_user.active_flag as active_flag_user ", $this->input->get('params'),$this->input->get('limit'),$this->input->get('start'));
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
			'tenant_id'     => $this->input->post('tenant_id'),
			'create_on' 	=> date("Y-m-d"),
			'active_flag'   => $this->convert_bit_bool($this->input->post('active')),
		);

		$this->App_employee->set_database($this->load->database('default',TRUE));
		$parameter['employee_id'] = $this->App_employee->get(" max(employee_id) as id");
		if ($parameter['employee_id']->num_rows() > 0) {
			$parameter['employee_id'] = $parameter['employee_id']->row()->id + 1;
		}

		$result = $this->App_employee->create($parameter);
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
			'tenant_id'     => $this->input->post('tenant_id'),
			'create_on' 	=> date("Y-m-d"),
			'active_flag'   => $this->convert_bit_bool($this->input->post('active')),
		);

		$this->App_employee->set_database($this->load->database('default',TRUE));
		$result = $this->App_employee->update($criteria, $parameter);
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

		$this->App_employee->set_database($this->load->database('default',TRUE));
		if (count(json_decode($parameter['id'])) > 0) {
			foreach (json_decode($parameter['id']) as $key => $value) {
				$criteria 					= array();
				$criteria['employee_id'] 	= $value;
				$query = $this->App_employee->delete($criteria);
				if ($query['result'] === false || $query['result'] == 0) {
					break;
				}
			}
		}else{
			$criteria 				= array();
			$criteria['employee_id'] 	= $parameter['id'];
			$query = $this->App_employee->delete($criteria);
		}

		if ($query['result'] > 0 || $query['result'] === true) {
			$response['status'] 	= 200;
			$response['message'] 	= "Update user account success";
		}else{
			$response['status'] 	= 401;
			$response['message'] 	= $query['error']['message'];
		}
		echo json_encode($response);
	}

	public function user_generate(){
		$response 	= array();
		$parameter 	= array(
			'employee_id' 		=> $this->input->post('employee_id'),
			'username' 				=> $this->input->post('username'),
			'change_password' => $this->input->post('change_password'),
			'password' 				=> $this->input->post('password'),
			'role_id' 				=> $this->input->post('role'),
			'tenant_id'				=> $this->input->post('tenant_id'),
			'active' 					=> $this->input->post('active'),
		);

		// $this->App_user->set_database($this->load->database('default',TRUE));
		// $query = $this->App_user->get("*", array( 'user_code' => $parameter['username'] ));
		// if($query->num_rows() == 0){
				$this->App_user->set_database($this->load->database('default',TRUE));
				$query = $this->App_user->get("*", array( 'employee_id' => $parameter['employee_id'] ));
				if ($query->num_rows() > 0) {
						$params 	= array();
						$criteria = array();
						$criteria['employee_id'] 	= $parameter['employee_id'];
						$criteria['user_id'] 			= $query->row()->user_id;

						$params['user_code'] 		= $parameter['username'];
						$params['active_flag'] 	= $this->convert_bit_bool($parameter['active']);
						$params['tenant_id'] 		= $parameter['tenant_id'];
						$params['role_id'] 			= $parameter['role_id'];
						$params['update_on'] 		= date("Y-m-d H:i:s");
						$params['update_by'] 		= $this->session->userdata('user_id');
						if ($parameter['change_password'] === true || $parameter['change_password'] === 'true') {
								$params['password'] 	= md5($parameter['password']);
						}

						$query = $this->App_user->update($criteria, $params);
						if ($query['result'] > 0 || $query['result'] === true) {
							$response['status'] 	= 200;
							$response['message'] 	= "Update user account success";
						}else{
							$response['status'] 	= 401;
							$response['message'] 	= $query['error']['message'];
						}
				}else{
						$this->App_user->set_database($this->load->database('default',TRUE));
						$query = $this->App_user->get(" max(user_id) as id ");
						if ($query->num_rows() > 0) {
							$parameter['user_id'] = (int)$query->row()->id + 1;
						}else{
							$parameter['user_id'] = 1;
						}

						if ($parameter['change_password'] === true || $parameter['change_password'] === 'true') {
							$params['password'] 	= md5($parameter['password']);
						}else{
							$params['password'] 	= md5('123456');
						}
						$params['user_id'] 			= $parameter['user_id'];
						$params['user_code'] 		= $parameter['username'];
						$params['user_code'] 		= $parameter['username'];
						$params['employee_id']	= $parameter['employee_id'];
						$params['role_id'] 			= $parameter['role_id'];
						$params['tenant_id'] 		= $parameter['tenant_id'];
						$params['active_flag'] 	= $this->convert_bit_bool($parameter['active']);
						$params['update_on'] 		= date("Y-m-d H:i:s");
						$params['update_by'] 		= $this->session->userdata('user_id');

						$query = $this->App_user->create($params);
						if ($query['result'] > 0 || $query['result'] === true) {
							$response['status'] 	= 200;
							$response['message'] 	= "Create user account success";
						}else{
							$response['status'] 	= 401;
							$response['message'] 	= $query['error']['message'];
						}
				}
		// }else{
		// 	$response['status'] 	= 401;
		// 	$response['message']	= "Username is already";
		// }

		echo json_encode($response);
	}
}
