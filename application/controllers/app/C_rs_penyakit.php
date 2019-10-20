<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_rs_penyakit extends CI_Controller {
	protected $_ci;

	public function __construct(){
		parent::__construct();
		$this->_ci = &get_instance();
		$this->load->model('Rs_penyakit');
	}

	public function index(){
		// $this->load->view('index', $response);
	}

	public function get($criteria = null){
		$this->Rs_penyakit->set_database($this->load->database('default',TRUE));

		$result = $this->Rs_penyakit->get("*", $this->input->get('params'), $this->input->get('limit'), $this->input->get('start'));
		echo json_encode(
			array(
				'results' => $result->result(),
				'total' 	=> $this->Rs_penyakit->get(" COALESCE(count(*),0) as count ")->row()->count,
				'status'	=> 200,
			)
		);
	}

	public function save(){
		$response 	= array();
		/*

			kd_penyakit 			: win.items.items[0].value,
			parent 						: win.items.items[1].value,
			penyakit					: win.items.items[2].value,
			description 			: win.items.items[3].value,
			note 							: win.items.items[4].value,
			includes 					: win.items.items[5].value,
			exclude 					: win.items.items[6].value,
		*/
		$parameter 	= array(
			'kd_penyakit'				=> $this->input->post('kd_penyakit'),
			'parent'						=> $this->input->post('parent'),
			'penyakit'					=> $this->input->post('penyakit'),
			'description'				=> $this->input->post('description'),
			'note'							=> $this->input->post('note'),
			'includes'					=> $this->input->post('includes'),
			'exclude'						=> $this->input->post('exclude'),
			'status'						=> $this->convert_bit_bool($this->input->post('status')),
			'non_rujukan_flag'	=> $this->convert_bit_bool($this->input->post('non_rujukan_flag')),
		);

		$this->Rs_penyakit->set_database($this->load->database('default',TRUE));
		$query = $this->Rs_penyakit->get(" * ",array( 'kd_penyakit' => $parameter['kd_penyakit'] ));
		if ($query->num_rows() > 0) {
			$result = array(
				'result' => 0,
				'error' => array(
					'code'		=> 401,
					'message'	=> "Kode penyakit telah terdaftar",
				),
			);
		}else{
			$result = $this->Rs_penyakit->create($parameter);
		}

		if ($result['result'] > 0 || $result['result'] === true) {
			$response['status'] 	= 200;
			$response['message'] 	= "Simpan penyakit berhasil";
		}else{
			$response['status'] 	= 401;
			$response['message'] 	= $result['error']['message'];
		}
		echo json_encode($response);
	}

	public function update(){
		$response 	= array();
		$criteria 	= array(
			'kd_penyakit'				=> $this->input->post('kd_penyakit'),
		);
		$parameter 	= array(
			'parent'						=> $this->input->post('parent'),
			'penyakit'					=> $this->input->post('penyakit'),
			'description'				=> $this->input->post('description'),
			'note'							=> $this->input->post('note'),
			'includes'					=> $this->input->post('includes'),
			'exclude'						=> $this->input->post('exclude'),
			'status'						=> $this->convert_bit_bool($this->input->post('status')),
			'non_rujukan_flag'	=> $this->convert_bit_bool($this->input->post('non_rujukan_flag')),
		);

		$this->Rs_penyakit->set_database($this->load->database('default',TRUE));
		$result = $this->Rs_penyakit->update($criteria, $parameter);

		if ($result['result'] > 0 || $result['result'] === true) {
			$response['status'] 	= 200;
			$response['message'] 	= "Update penyakit berhasil";
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

		$this->Rs_penyakit->set_database($this->load->database('default',TRUE));
		if (count(json_decode($parameter['id'])) > 0) {
			foreach (json_decode($parameter['id']) as $key => $value) {
				$criteria 				= array();
				$criteria['kd_penyakit'] 	= $value;
				$result 	= $this->Rs_penyakit->delete($criteria);
				if ($result['result'] === false || $result['result'] == 0) {
					break;
				}
			}
		}else{
			$criteria 				= array();
			$criteria['kd_penyakit'] 	= $parameter['id'];
			$result = $this->Rs_penyakit->delete($criteria);
		}

		if ($result['result'] > 0 || $result['result'] === true) {
			$response['status'] 	= 200;
			$response['message'] 	= "hapus penyakit berhasil";
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
