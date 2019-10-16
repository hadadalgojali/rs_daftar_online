<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_app_religion extends CI_Controller {
	protected $_ci;

	public function __construct(){
		parent::__construct();
		$this->_ci = &get_instance();
		$this->load->model('App_religion');
	}

	public function index(){
		// $this->load->view('index', $response);
	}

	public function get($criteria = null){
		$this->App_religion->set_database($this->load->database('default',TRUE));

		$App_religion = $this->App_religion->get(" * ", $this->input->get('params'),$this->input->get('limit'),$this->input->get('start'));
		echo json_encode(
			array(
				'results' 	=> $App_religion->result(),
				'total' 	=> $App_religion->num_rows(),
				'status'	=> 200,
			)
		);
	}
}
