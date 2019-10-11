<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daftar extends CI_Controller {
	protected $_ci;

	public function __construct(){
		parent::__construct();
		$this->_ci = &get_instance();
		$this->load->model('Rs_patient');
		$this->load->model('Rs_customer');
		$this->load->model('Rs_unit');
		$this->load->model('Rs_visit');
		$this->load->model('Rs_dokter_klinik');
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
		$this->Rs_patient->set_database($this->load->database('default',TRUE));

		$response     = array();
		$response['status'] = false;
		$parameter 	= array(
			'kd_pasien' 	=> $this->input->post('kd_pasien'),
			'tgl_lahir' 	=> $this->input->post('tgl_lahir'),
		);
		$response['parameter'] = $parameter;

		$format_date = explode("-", $parameter['tgl_lahir']);
		$format_date = $format_date[2]."-".$format_date[1]."-".$format_date[0];

		$response['patient'] = $this->Rs_patient->get("*", array(
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
		$this->Rs_customer->set_database($this->load->database('default',TRUE));
		$response 	= array();
		$response['status'] = false;

		$response['customer'] = $this->Rs_customer->get();

		if ($response['customer']->num_rows() > 0) {
			$response['customer'] 	= $response['customer']->result();
			$response['status'] 	= true;
		}

		echo json_encode($response);
	}

	public function search_unit(){
		$this->Rs_unit->set_database($this->load->database('default',TRUE));
		$response 	= array();
		$response['status'] = false;

		$parameter 	= array();
		$criteria  	= json_decode($this->input->post('criteria'));
		$parameter['unit_type'] = $criteria->unit_type;
		$response['unit'] = $this->Rs_unit->get("*", $parameter);

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
		$parameter['tgl_kunjungan'] = explode("-", $parameter['tgl_kunjungan']);
		$parameter['tgl_kunjungan'] = $parameter['tgl_kunjungan'][2]."-".$parameter['tgl_kunjungan'][1]."-".$parameter['tgl_kunjungan'][0];
		$parameter['telepon']		= $this->input->post('telepon');
		$parameter['unit_code']		= $this->input->post('klinik');
		$parameter['no_rujukan']	= $this->input->post('no_rujukan');
		$parameter['data_rujukan']	= json_decode($this->input->post('data_rujukan'));

		$this->Rs_patient->set_database($this->load->database('default',TRUE));
		$response['patient'] = $this->Rs_patient->get("*", array('patient_code' => $parameter['patient_code']));
		if ($response['patient']->num_rows()>0) {
			$response['patient'] = $response['patient']->result();
		}

		$this->Rs_unit->set_database($this->load->database('default',TRUE));
		$response['unit'] = $this->Rs_unit->get("*", array('unit_code' => $parameter['unit_code']));
		if ($response['unit']->num_rows()>0) {
			$response['unit'] = $response['unit']->result();

			$this->Rs_dokter_klinik->set_database($this->load->database('default',TRUE));
			$parameter['id_dokter_klinik'] = $this->Rs_dokter_klinik->get(" employee_id ", array( 'unit_id' => $response['unit'][0]->unit_id ) );
			if ($parameter['id_dokter_klinik']->num_rows()>0) {
				$parameter['id_dokter_klinik'] = $parameter['id_dokter_klinik']->row()->employee_id;
			}		

			$this->Rs_visit->set_database($this->load->database('default',TRUE));
			$parameter['no_antrian'] = $this->Rs_visit->get(" coalesce(count(*),0) + 1 as no_antrian ", array( 'entry_date' =>  $parameter['tgl_kunjungan'], 'unit_id' => $response['unit'][0]->unit_id) );
			if ($parameter['no_antrian']->num_rows()>0) {
				$parameter['no_antrian'] = $parameter['no_antrian']->row()->no_antrian;
			}
		}

		$this->Rs_customer->set_database($this->load->database('default',TRUE));
		$response['customer'] = $this->Rs_customer->get("*", array('customer_code' => $parameter['kd_customer']));
		if ($response['customer']->num_rows()>0) {
			$response['customer'] = $response['customer']->result();
		}

		$this->Rs_visit->set_database($this->load->database('default',TRUE));
		$parameter['id_visit'] = $this->Rs_visit->get(" max(visit_id)+1 as id ", null);
		if ($parameter['id_visit']->num_rows()>0) {
			$parameter['id_visit'] = $parameter['id_visit']->row()->id;
		}		

		$this->Rs_visit->set_database($this->load->database('default',TRUE));
		$parameter['no_pendaftaran'] = $this->Rs_visit->get(" coalesce(count(*),0) + 1 as no_pendaftaran ", array( 'tgl_daftar' => date('Y-m-d') ) );
		if ($parameter['no_pendaftaran']->num_rows()>0) {
			$format 						= "000";
			$parameter['no_pendaftaran'] 	= substr($format, 0,-strlen($parameter['no_pendaftaran']->row()->no_pendaftaran)).$parameter['no_pendaftaran']->row()->no_pendaftaran;
		}		

		$response['parameter'] = $parameter;

		$response['message'] = "";
		if (count($response['patient'])>0 && count($response['unit'])>0 && count($response['customer'])>0) {
			$response['message'] 	= "Proses simpan data kunjungan";

			$this->Rs_visit->set_database($this->load->database('default',TRUE));
			$Rs_visit = $this->Rs_visit->get("*", array( 'patient_id' => $response['patient'][0]->patient_id, 'unit_id' => $response['unit'][0]->unit_id, 'entry_date' => $parameter['tgl_kunjungan'], 'hadir' => '0' ) );
			if ($Rs_visit->num_rows() == 0) {
				$response['status'] 	= $this->Rs_visit->create(
					array(
						'visit_id' 				=> $parameter['id_visit'],
						'patient_id' 			=> $response['patient'][0]->patient_id,
						'unit_id' 				=> $response['unit'][0]->unit_id,
						'entry_date' 			=> $parameter['tgl_kunjungan'],
						'entry_seq' 			=> '1',
						'dokter_id'				=> $parameter['id_dokter_klinik'],
						'no_antrian'			=> $parameter['no_antrian'],
						'customer_id'			=> $response['customer'][0]->customer_id,
						'status_dilayani'		=> '0',
						'kode_sep'				=> '',
						'nama_peserta'			=> '',
						'nomor_peserta'			=> '',
						'no_pendaftaran'		=> substr(date('Y'), -2).date('m').date('d').$parameter['no_pendaftaran'],
						'poli_tujuan'			=> '',
						'no_rujukan'			=> $parameter['no_rujukan'],
						'diagnosa'				=> '',
						'faskes_asal'			=> '',
						'kd_rujukan'			=> '',
						'kelas'					=> '',
						'hadir'					=> 0,
						'jenis_daftar'			=> 'JNSDFTR_ONLINE',
						'baru'					=> 0,
						'pbi'					=> 0,
						'non_pbi'				=> 0,
						'keluhan'				=> $parameter['keluhan'],
						'jenis_kunjungan_bpjs' 	=> $parameter['jenis_penjamin'],
						'tgl_daftar' 			=> date('Y-m-d'),
						'kd_kelas' 				=> $parameter['data_rujukan']->kd_kelas,
						'kd_poli' 				=> $parameter['data_rujukan']->kd_poli,
						'kd_diagnosa' 			=> $parameter['data_rujukan']->kd_diagnosa,
						'rujukan' 				=> $parameter['data_rujukan']->rujukan,
						'faskes' 				=> $parameter['data_rujukan']->faskes,
						'tgl_rujukan' 			=> $parameter['data_rujukan']->tgl_rujukan,
						'kd_dpjp' 				=> $parameter['data_rujukan']->kd_dpjp,

					)
				);
				$response['parameter']['no_pendaftaran']= substr(date('Y'), -2).date('m').date('d').$parameter['no_pendaftaran'];
			}else{
				$response['parameter']['no_pendaftaran'] = $Rs_visit->row()->no_pendaftaran;
				$response['status'] = true;
			}
		}

		$response['parameter']['tgl_kunjungan'] = date_format(date_create($response['parameter']['tgl_kunjungan']), "d/M/Y");
		if ($response['status'] > 0) {
			$response['status'] = true;
		}else{
			$response['status'] = false;
		}
		echo json_encode($response);
	}

}