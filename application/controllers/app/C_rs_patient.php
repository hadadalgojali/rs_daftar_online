<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_rs_patient extends CI_Controller {
	protected $_ci;

	public function __construct(){
		parent::__construct();
		$this->_ci = &get_instance();
		$this->load->model('Rs_patient');
		$this->load->model('Pasien');
	}

	public function index(){
		// $this->load->view('index', $response);
	}

	public function get($criteria = null){
		$this->Rs_patient->set_database($this->load->database('default',TRUE));
		$result = $this->Rs_patient->get("*", $this->input->get('params'), $this->input->get('limit'), $this->input->get('start'));
		echo json_encode(
			array(
				'results' => $result->result(),
				'total' 	=> $this->Rs_patient->get(" COALESCE(count(*),0) as count ")->row()->count,
				'status'	=> 200,
			)
		);
	}

	public function save(){
		$db_default = $this->load->database('default',TRUE);
		$db_second  = $this->load->database('second',TRUE);
		$db_default->trans_start();
		$db_second->trans_start();
		$response 	= array();
		$parameter 	= array(
			'patient_code'		=> $this->input->post('patient_code'),
			'title'				=> $this->input->post('title'),
			'name'				=> $this->input->post('name'),
			'birth_place'		=> $this->input->post('birth_place'),
			'birth_date'		=> $this->input->post('birth_date'),
			'address'			=> $this->input->post('address'),
			'phone_number'		=> $this->input->post('telepon'),
			'postal_code'		=> $this->input->post('pos_code'),
			'gender'			=> $this->input->post('gender'),
			'religion_id'		=> $this->input->post('religion_id'),
			'education_id'		=> $this->input->post('education_id'),
			'jobdesk_id'		=> $this->input->post('jobdesk_id'),
			'country_id'		=> $this->input->post('country_id'),
			'province_id'		=> $this->input->post('province_id'),
			'district_id'		=> $this->input->post('district_id'),
			'districts_id'		=> $this->input->post('districts_id'),
			'kelurahan_id'		=> $this->input->post('kelurahan_id'),
		);

		$this->Rs_patient->set_database($this->load->database('default',TRUE));
		$parameter['patient_id'] = $this->Rs_patient->get(" max(patient_id) as id");
		if ($parameter['patient_id']->num_rows() > 0) {
			$parameter['patient_id'] = $parameter['patient_id']->row()->id + 1;
		}

		$this->Rs_patient->set_database($this->load->database('default',TRUE));
		$result = $this->Rs_patient->create($parameter);

		if ($result['result'] > 0 || $result['result'] === true) {
			unset($parameter);
			$parameter['kd_pasien'] 	= $this->input->post('patient_code');
			$parameter['nama'] 			= $this->input->post('name');
			$parameter['tgl_lahir']		= $this->input->post('birth_date');
			$parameter['jenis_kelamin']	= $this->input->post('gender');
			$parameter['alamat']		= $this->input->post('address');
			$parameter['telepon']		= $this->input->post('telepon');
			$parameter['kd_pos']		= $this->input->post('pos_code');
			$parameter['tempat_lahir']	= $this->input->post('birth_place');
			$parameter['wni']			= 1;
			$parameter['kd_suku']		= 1;

			$this->Pasien->set_database($this->load->database('second',TRUE));
			$result = $this->Pasien->create($parameter);

		}

		if ($result['result'] > 0 || $result['result'] === true) {
			$response['status'] 	= 200;
			$response['message'] 	= "Create success";
			$db_default->trans_commit();
			$db_second->trans_commit();
		}else{
			$response['status'] 	= 401;
			$response['message'] 	= $result['error']['message'];
			$db_default->trans_rollback();
			$db_second->trans_rollback();
		}

		$db_default->close();
		$db_second->close();
		echo json_encode($response);
	}

	public function update(){
		$response 	= array();
		$criteria 	= array(
			'patient_id'		=> $this->input->post('patient_id'),
		);
		$parameter 	= array(
			'patient_code'		=> $this->input->post('patient_code'),
			'title'				=> $this->input->post('title'),
			'name'				=> $this->input->post('name'),
			'birth_place'		=> $this->input->post('birth_place'),
			'birth_date'		=> $this->input->post('birth_date'),
			'address'			=> $this->input->post('address'),
			'phone_number'		=> $this->input->post('telepon'),
			'postal_code'		=> $this->input->post('pos_code'),
			'gender'			=> $this->input->post('gender'),
			'religion_id'		=> $this->input->post('religion_id'),
			'education_id'		=> $this->input->post('education_id'),
			'jobdesk_id'		=> $this->input->post('jobdesk_id'),
			'country_id'		=> $this->input->post('country_id'),
			'province_id'		=> $this->input->post('province_id'),
			'district_id'		=> $this->input->post('district_id'),
			'districts_id'		=> $this->input->post('districts_id'),
			'kelurahan_id'		=> $this->input->post('kelurahan_id'),
		);

		$this->Rs_patient->set_database($this->load->database('default',TRUE));
		$result = $this->Rs_patient->update($criteria, $parameter);
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

		$this->Rs_patient->set_database($this->load->database('default',TRUE));
		if (count(json_decode($parameter['id'])) > 0) {
			foreach (json_decode($parameter['id']) as $key => $value) {
				$criteria 				= array();
				$criteria['patient_id'] = $value;
				$result 	= $this->Rs_patient->delete($criteria);
				if ($result['result'] === false || $result['result'] == 0) {
					break;
				}
			}
		}else{
			$criteria 				= array();
			$criteria['patient_id'] = $parameter['id'];
			$result = $this->Rs_patient->delete($criteria);
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

	public function get_last_medrec(){
		$response 	= array();
		$query 		= " SELECT CAST(MAX(REPLACE(kd_pasien, '-', '')) as INT) as kd_pasien FROM pasien ";
		$conn 		= $this->load->database('second',TRUE);
		$conn 		= $conn->query($query);

		$medrec 	= "0-00-00-01"; 
		if ($conn->num_rows() > 0) {
			$medrec = "0-00-00-00"; 
			$medrec = str_replace("-", "", $medrec);
			$medrec = substr($medrec, 0, -(strlen($conn->row()->kd_pasien))).((int)$conn->row()->kd_pasien + 1);
			$medrec = substr($medrec, 0, 1)."-".substr($medrec, 1, 2)."-".substr($medrec, 3, 2)."-".substr($medrec, 5, 2);
		}
		$response['count'] = $conn->num_rows();
		$response['status']= true;
		$response['medrec']= $medrec;
		echo json_encode($response);
	}
}
