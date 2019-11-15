<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkin extends CI_Controller {
	protected $_ci;

	public function __construct(){
		parent::__construct();
		$this->_ci = &get_instance();
		include('./config.php');
		$this->load->model('Rs_visit');
	}

	public function index(){
		include('./config.php');
		$response = array();
		$response['data_rs'] = $conf_db['rs'];
		$response['_include_css'] = $this->_ci->load->view('partials/include_css', $response, TRUE);
		$response['_header']      = $this->_ci->load->view('partials/header-checkin', $response, TRUE);
		$response['_include_js']  = $this->_ci->load->view('partials/include_js', $response, TRUE);
		$this->load->view('pages/checkin/index', $response);
	}

	public function search_process(){
		$response = array();
		$response['status'] = true;
		$response['code'] 	= 200;
		$response['message']= "";
		$this->Rs_visit->set_database($this->load->database('default',TRUE));
		$query = $this->Rs_visit->get_with_relation(" rs_patient.patient_code ", array(
			'rs_visit.no_pendaftaran' => $this->input->post('no_pendaftaran'),
		));
		if ($query->num_rows() > 0) {
			$this->load->view('pages/checkin/step2-review', $query->result());
		}else{
			$response['status'] = false;
			$response['code'] 	= 401;
			$response['message']= "Data tidak ditemukan";
			$this->load->view('pages/checkin/step1-search', $response);
		}
	}

	public function search_form(){
		$response = array();
		$response['status'] = true;
		$response['code'] 	= 200;
		$response['message']= "";
		$this->load->view('pages/checkin/step1-search', $response);

	}
}
