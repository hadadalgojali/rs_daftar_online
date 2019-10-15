<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
	protected $_ci;

	public function __construct(){
		parent::__construct();
		$this->_ci = &get_instance();
		$this->load->model('App_user');
		$this->load->model('App_role_menu');
		$this->load->model('App_menu');
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
		$response['app_user'] = $this->App_user->get_with_employee(" app_user.user_id, app_user.user_code, app_user.role_id, app_employee.* ", array(
			'app_user.user_code' 	=> $parameter['user_code'],
			'app_user.password' 	=> $parameter['password'],
		));
		
		if ($response['app_user']->num_rows() > 0) {
			$response['app_user'] = $response['app_user']->result();
			$new_session = array(
				'user_id'  		=> $response['app_user'][0]->user_id,
				'user_code' 	=> $response['app_user'][0]->user_code,
				'first_name' 	=> $response['app_user'][0]->first_name,
				'role_id' 		=> $response['app_user'][0]->role_id,
			);
			$this->session->set_userdata($new_session);
		}

		// echo json_encode($response);
		redirect(base_url());
	}

	public function get_session(){
		echo json_encode($this->session->userdata());
	}

	public function get_menu(){
		$response 			= array();
		$response['menu'] 	= array();
		$this->App_role_menu->set_database($this->load->database('default',TRUE));
		$menu = $this->App_role_menu->get_with_menu("*", array( 'role_id' =>  $this->session->userdata('role_id'), 'active_flag' =>  1 ));
		if ($menu->num_rows() > 0) {
			foreach ($menu->result() as $res_menu) {
				$_menu = array();
				if ($res_menu->parent_id == null || $res_menu->parent_id == '') {
					$_menu['menu']	= array();
					$_menu['text']  = $res_menu->menu_name;

					$_menu_parent = array(); 
					foreach ($menu->result() as $res_menu_parent) {
						if ($res_menu_parent->parent_id ==  $res_menu->menu_id ) {
							$_menu_parent['code'] 		= $res_menu_parent->menu_code;
							$_menu_parent['handler'] 	= "loadMenu";
							$_menu_parent['role'] 		= $res_menu_parent->menu_command;
							$_menu_parent['text'] 		= $res_menu_parent->menu_name;
							$_menu_parent['win'] 		= false;
							array_push($_menu['menu'], $_menu_parent);
						}
					}
					array_push($response['menu'], $_menu);
				}
			}
		}
		echo json_encode($response);
	}

	private function get_parent_menu(){

	}

	public function destroy_session(){
		$this->session->sess_destroy();
		echo json_encode(
			array(
				'status'	=> 200,
			)
		);
	}
}
