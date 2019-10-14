<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
	protected $_ci;

	public function __construct(){
		parent::__construct();
		$this->_ci = &get_instance();
		$this->load->model('App_user');
	}

	public function login(){
		$response = array();

		$response['_incl_css']      = $this->_ci->load->view('partials/include_css_login', $response, TRUE);
		$response['_incl_js']       = $this->_ci->load->view('partials/include_js_login', $response, TRUE);
		$this->load->view(
			'pages/auth/login', $response
		);
	}

	public function logging(){
		$response 	= array();
		$parameter 	= array();
		$parameter['user_code'] = $this->input->post('username');
		$parameter['password'] 	= md5($this->input->post('password'));

		$this->App_user->set_database($this->load->database('default',TRUE));
		$response['app_user'] = $this->App_user->get_with_employee(" app_user.user_id, app_user.user_code, app_employee.* ", array(
			'app_user.user_code' 	=> $parameter['user_code'],
			'app_user.password' 	=> $parameter['password'],
		));
		
		if ($response['app_user']->num_rows() > 0) {
			$response['app_user'] = $response['app_user']->result();
			$new_session = array(
				'user_id'  		=> $response['app_user'][0]->user_id,
				'user_code' 	=> $response['app_user'][0]->user_code,
				'first_name' 	=> $response['app_user'][0]->first_name,
			);
			$this->session->set_userdata($new_session);
		}

		// echo json_encode($response);
		redirect(base_url());
	}
}
