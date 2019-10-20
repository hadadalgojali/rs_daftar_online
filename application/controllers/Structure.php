<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Structure extends CI_Controller {
	protected $_ci;

	public function __construct(){
		parent::__construct();
		$this->_ci = &get_instance();
		$this->load->model("M_structure");
	}

	public function get(){
		$response = array();
		$conn = $this->input->get('table');
		$this->M_structure->set_database($this->load->database((string)$conn,TRUE));
		$criteria = $this->input->get('params');
		if($criteria !='' || strlen($criteria) > 0){
			$criteria = " where ".$criteria;
		}

		$query = $this->M_structure->get($criteria);
		if($query->num_rows() > 0){
			$response['count'] = $query->num_rows();
			$response['results']= $query->result();
		}else{
			$response['count'] = 0;
			$response['results']= array();
		}
		echo json_encode($response);
	}
}
