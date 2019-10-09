<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daftar extends CI_Controller {
	protected $_ci;

	public function __construct(){
		parent::__construct();
		$this->_ci = &get_instance();
		$this->load->model('rs_patient');
		$this->load->model('rs_customer');
		$this->load->model('rs_unit');
		$this->load->helper('captcha');
	}

	public function index(){
		include('./config.php');
		$response = array();
		$response['data_rs'] = $conf_db['rs'];
		$this->load->view('pages/registrasi/lama', $response);
	}

	public function registrasi($page = null){
		include('./config.php');
		$response = array();
		$response['data_rs'] = $conf_db['rs'];
		
		$response['_header']      	= $this->_ci->load->view('partials/header', $response, TRUE);
		$response['_menu']        	= $this->_ci->load->view('partials/menu', $response, TRUE);
		$response['_footer']      	= $this->_ci->load->view('partials/footer', $response, TRUE);
		$response['_include_css'] 	= $this->_ci->load->view('partials/include_css', $response, TRUE);
		$response['_include_js']  	= $this->_ci->load->view('partials/include_js', $response, TRUE);

		$response['check_in_at'] 	= $conf_app['check_in_at'];
		$response['check_in_to'] 	= $conf_app['check_in_to'];
		$response['tanggal_at'] 	= "-".$conf_app['tanggal_at'];
		$response['tanggal_to'] 	= "+".$conf_app['tanggal_to'];

		$vals = array(
			'img_path'   => './assets/image/captcha/',
			'img_url'    => base_url().'assets/image/captcha/',
			'img_width'  => '160',
			'img_height' => 40,
			'border'     => 0, 
			'font_size'  => 30,
			'expiration' => 4000,
			'colors'     => array(
					'background' => array(255, 255, 255),
					'border'     => array(158, 252, 230),
					'text'       => array(0, 0, 0),
					'grid'       => array(158, 252, 230),
			)
		);

		$cap = create_captcha($vals);
		$response['image_captcha'] 	= $cap['image'];
		$response['word_captcha'] 	= $cap['word'];
		$this->load->view('pages/registrasi/'.$page, $response);
	}

	public function search_patient(){
		$this->rs_patient->set_database($this->load->database('default',TRUE));

		$response     = array();
		$response['status'] = false;
		$parameter 	= array(
			'kd_pasien' 	=> $this->input->post('kd_pasien'),
			'tgl_lahir' 	=> $this->input->post('tgl_lahir'),
		);
		$response['parameter'] = $parameter;

		$format_date = explode("-", $parameter['tgl_lahir']);
		$format_date = $format_date[2]."-".$format_date[1]."-".$format_date[0];

		$response['patient'] = $this->rs_patient->get("*", array(
			'patient_code' 	=> $parameter['kd_pasien'],
			'birth_date' 	=> $format_date,
		));

		if ($response['patient']->num_rows() > 0) {
			$response['patient'] 	= $response['patient']->result();
			$response['status'] 	= true;
		}

		echo json_encode($response);
	}

	public function search_customer(){
		$this->rs_customer->set_database($this->load->database('default',TRUE));
		$response 	= array();
		$response['status'] = false;

		$response['customer'] = $this->rs_customer->get();

		if ($response['customer']->num_rows() > 0) {
			$response['customer'] 	= $response['customer']->result();
			$response['status'] 	= true;
		}

		echo json_encode($response);
	}

	public function search_unit(){
		$this->rs_unit->set_database($this->load->database('default',TRUE));
		$response 	= array();
		$response['status'] = false;

		$parameter 	= array();
		$criteria  	= json_decode($this->input->post('criteria'));
		$parameter['unit_type'] = $criteria->unit_type;
		$response['unit'] = $this->rs_unit->get("*", $parameter);

		if ($response['unit']->num_rows() > 0) {
			$response['unit'] 	= $response['unit']->result();
			$response['status'] 	= true;
		}

		echo json_encode($response);
	}

	public function create(){
		$response 	= array();
		$response['status'] = false;
		$parameter 	= array();
		$parameter['patient_code'] 	= $this->input->post('patient_code');
		$parameter['kd_customer'] 	= $this->input->post('penjamin');
		$parameter['jenis_penjamin']= $this->input->post('jenis_kunjungan');
		$parameter['keluhan'] 		= $this->input->post('keluhan');
		$parameter['tgl_kunjungan']	= $this->input->post('tgl_kunjungan');
		$parameter['telepon']		= $this->input->post('telepon');
		$parameter['unit_code']		= $this->input->post('klinik');
		$parameter['no_rujukan']	= $this->input->post('no_rujukan');

		$this->rs_patient->set_database($this->load->database('default',TRUE));
		$response['patient'] = $this->rs_patient->get("*", array('patient_code' => $parameter['patient_code']));
		if ($response['patient']->num_rows()>0) {
			$response['patient'] = $response['patient']->result();
		}

		$this->rs_unit->set_database($this->load->database('default',TRUE));
		$response['unit'] = $this->rs_unit->get("*", array('unit_code' => $parameter['unit_code']));
		if ($response['unit']->num_rows()>0) {
			$response['unit'] = $response['unit']->result();
		}

		
		echo json_encode($response);
	}
}