<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
	protected $_ci;

	public function __construct(){
		parent::__construct();
		$this->_ci = &get_instance();

		include('./config.php');
		$response = array();
		$response['data_rs'] = $conf_db['rs'];

		$response['_header']      = $this->_ci->load->view('partials/header', $response, TRUE);
		$response['_menu']        = $this->_ci->load->view('partials/menu', $response, TRUE);
		$response['_footer']      = $this->_ci->load->view('partials/footer', $response, TRUE);
		$response['_include_css'] = $this->_ci->load->view('partials/include_css', $response, TRUE);
		$response['_include_js']  = $this->_ci->load->view('partials/include_js', $response, TRUE);

		if ($this->session->userdata('user_id') == null && $this->session->userdata('user_id') == '') {
			$this->load->view('index', $response);
		}else{
			$this->load->view('pages/admin/index', $response);
		}
	}

	public function index(){
		// $this->load->view('index', $response);
	}

	// private function admin(){
	// 	echo "Halaman login";
	// 	$this->session->sess_destroy();
	// }
}
