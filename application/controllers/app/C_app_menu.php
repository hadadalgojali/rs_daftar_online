<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_app_menu extends CI_Controller {
	protected $_ci;

	public function __construct(){
		parent::__construct();
		$this->_ci = &get_instance();
		$this->load->model('App_menu');
	}

	public function index(){
		// $this->load->view('index', $response);
	}

	public function get(){
		
	}
}
