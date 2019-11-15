<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Structure extends CI_Controller {
	protected $_ci;

	public function __construct(){
		parent::__construct();
		$this->_ci = &get_instance();
		$this->load->model("M_structure");
		$this->load->model("Pasien");
	}

	public function get(){
		$response = array();
		$conn = $this->input->get('table');
		$this->M_structure->set_database($this->load->database((string)$conn,TRUE));
		$criteria = $this->input->get('params');
		if($criteria !='' || strlen($criteria) > 0){
			$criteria = " where ".$criteria;
		}

		$select = "";
		if ($conn=='default') {
			$select = ", COLUMN_KEY as column_key";
		}
		$query = $this->M_structure->get($criteria, " DISTINCT(COLUMN_NAME) as column_name, DATA_TYPE as data_type ");
		if($query->num_rows() > 0){
			$response['count'] = $query->num_rows();
			$response['results']= $query->result();
		}else{
			$response['count'] = 0;
			$response['results']= array();
		}
		echo json_encode($response);
	}

	public function count_migrate(){
		$result 	= true;
		$data 		= 0;
		$parameter 	= array(
			'db_second' => $this->input->post('db_second'),
		);

		$this->Pasien->set_database($this->load->database('second', TRUE));
		$query = $this->Pasien->get($this->input->post('field')." as id ");
		if ($query->num_rows() > 0) {
			$data = $query->result();
		}
		
		echo json_encode(
			array(
				'status' 	=> $result,
				'code' 	 	=> 200,
				'data' 		=> $data,
				'count'		=> count($data),
			)
		);
	}

	public function migrate_data(){
		$response = array();
		$response['code'] 	= 200;
		$response['status'] = true;
		$parameter = array(
			'key_second' 	=> $this->input->post('key_second'),
			'key_default' 	=> $this->input->post('key_first'),
			'id' 			=> $this->input->post('id'),
			'second' 		=> $this->input->post('db_second'),
			'default' 		=> $this->input->post('db_default'),
			'field_second' 	=> $this->input->post('field_second'),
			'field_default' => $this->input->post('field_first'),
		);
		$parameter['json_field_second'] 	= explode(",", $parameter['field_second']);
		$parameter['json_field_default'] 	= explode(",", $parameter['field_default']);

		$this->M_structure->set_database($this->load->database('second', TRUE));
		$second = $this->M_structure->get_data(str_replace("'", "", $parameter['field_second']), $parameter['second'], array( $parameter['key_second'] => $parameter['id']));

		if ($second->num_rows() > 0) {
			foreach ($second->result_array() as $key => $value) {
				$params = array();
				for ($i=0; $i < count($parameter['json_field_second']); $i++) { 
					$params[str_replace("'", "",$parameter['json_field_default'][$i])] = $value[str_replace("'", "",$parameter['json_field_second'][$i])];
					// echo $parameter['json_field_second'][$i]."<br>";
					// var_dump($value);
					// echo $value[str_replace("'", "",$parameter['json_field_second'][$i])]."<br>";
				}

				// die;
				$this->M_structure->set_database($this->load->database('default', TRUE));
				$default = $this->M_structure->get_data("*", $parameter['default'], array( $parameter['key_default'] => $parameter['id']));
				if ($default->num_rows() == 0) {
					$default = $this->M_structure->get(" WHERE TABLE_NAME = '".$parameter['default']."' AND COLUMN_NAME not in (".$parameter['field_default'].")", " DISTINCT(COLUMN_NAME) as column_name, DATA_TYPE as data_type, COLUMN_KEY as column_key ");
					if ($default->num_rows() > 0) {
						if ($default->row()->column_key  == "PRI") {
							$params[$default->row()->column_name] = (int)$this->get_last_id($parameter['default'], $default->row()->column_name) + 1;
						}

						if(strtoupper($default->row()->data_type)  == "DATE"){
							$params[$default->row()->column_name] = date_format(date_create($params[$default->row()->column_name]), 'Y-m-d');
							// echo $params[$default->row()->column_name]."<br>";die;
						}

						if (!in_array($default->row()->column_name, str_replace("'", "",$parameter['json_field_default']))) {
							if ($default->row()->data_type  == "BIT" || $default->row()->data_type  == "INT" || $default->row()->data_type  == "INTEGER" || $default->row()->data_type  == "FLOAT") {
								$params[$default->row()->column_name] = 0;
							}else if($default->row()->data_type  == "STRING" || $default->row()->data_type  == "VARCHAR" || $default->row()->data_type  == "CHARACTER VARYING" || $default->row()->data_type  == "CHAR"){
								$params[$default->row()->column_name] = "";
							}else if($default->row()->data_type  == "DATE")
								$params[$default->row()->column_name] = "0000-00-00";{
							}
						}
					}

					$default = $this->M_structure->get(" WHERE TABLE_NAME = '".$parameter['default']."' AND COLUMN_NAME in (".$parameter['field_default'].")", " DISTINCT(COLUMN_NAME) as column_name, DATA_TYPE as data_type, COLUMN_KEY as column_key ");
					if ($default->num_rows() > 0) {
						foreach ($default->result() as $res) {
							if(strtoupper($res->data_type)  == "DATE"){
								$params[$res->column_name] = date_format(date_create($params[$res->column_name]), 'Y-m-d');
							}
						}
					}

					// var_dump($params);
					if ($this->M_structure->insert($parameter['default'], $params) == 0) {
						$result = false;
						break;
					}else{
						$result = true;
					}
				}
				// var_dump($params);
			}
		}

		// $this->M_structure->set_database($this->load->database('second', TRUE));

		echo json_encode($response);
	}

	public function migrate(){
		ini_set('memory_limit','256M'); // This also needs to be increased in some cases. Can be changed to a higher value as per need)
		ini_set('sqlsrv.ClientBufferMaxKBSize','524288'); // Setting to 512M
		ini_set('pdo_sqlsrv.client_buffer_max_kb_size','524288'); // Setting to 512M - for pdo_sqlsrv
		$result = true;
		$parameter = array(
			'second' 	=> json_decode($this->input->post('second')),
			'default' 	=> json_decode($this->input->post('default')),
		);

		$second = "";
		foreach ($parameter['second'] as $key => $value) {
			$second .= "'".$value."',";
		}
		$second = substr($second, 0, -1);
		
		$criteria_default = "";
		foreach ($parameter['default'] as $key => $value) {
			$criteria_default .= "'".$value."',";
		}
		$criteria_default = substr($criteria_default, 0, -1);

		$this->M_structure->set_database($this->load->database('second', TRUE));
		$second = $this->M_structure->get_data(str_replace("'", "", $second), $this->input->post('db_second'));

		if ($second->num_rows() > 0) {
			foreach ($second->result_array() as $key => $value) {
				$params = array();
				for ($i=0; $i < count($parameter['second']); $i++) { 
					$params[$parameter['default'][$i]] = $value[$parameter['second'][$i]];
				}

				$this->M_structure->set_database($this->load->database('default', TRUE));

				$default = $this->M_structure->get(" WHERE TABLE_NAME = '".$this->input->post('db_default')."' AND COLUMN_NAME not in (".$criteria_default.")", " DISTINCT(COLUMN_NAME) as column_name, DATA_TYPE as data_type, COLUMN_KEY as column_key ");
				if ($default->num_rows() > 0) {
					if ($default->row()->column_key  == "PRI") {
						$params[$default->row()->column_name] = (int)$this->get_last_id($this->input->post('db_default'), $default->row()->column_name) + 1;
					}

					if(strtoupper($default->row()->data_type)  == "DATE"){
						$params[$default->row()->column_name] = date_format(date_create($params[$default->row()->column_name]), 'Y-m-d');
						// echo $params[$default->row()->column_name]."<br>";die;
					}

					if (!in_array($default->row()->column_name, $parameter['default'])) {
						if ($default->row()->data_type  == "BIT" || $default->row()->data_type  == "INT" || $default->row()->data_type  == "INTEGER" || $default->row()->data_type  == "FLOAT") {
							$params[$default->row()->column_name] = 0;
						}else if($default->row()->data_type  == "STRING" || $default->row()->data_type  == "VARCHAR" || $default->row()->data_type  == "CHARACTER VARYING" || $default->row()->data_type  == "CHAR"){
							$params[$default->row()->column_name] = "";
						}else if($default->row()->data_type  == "DATE")
							$params[$default->row()->column_name] = "0000-00-00";{
						}
					}
				}

				$default = $this->M_structure->get(" WHERE TABLE_NAME = '".$this->input->post('db_default')."' AND COLUMN_NAME in (".$criteria_default.")", " DISTINCT(COLUMN_NAME) as column_name, DATA_TYPE as data_type, COLUMN_KEY as column_key ");
				if ($default->num_rows() > 0) {
					foreach ($default->result() as $res) {
						if(strtoupper($res->data_type)  == "DATE"){
							$params[$res->column_name] = date_format(date_create($params[$res->column_name]), 'Y-m-d');
						}
					}
				}

				if ($this->M_structure->insert($this->input->post('db_default'), $params) == 0) {
					$result = false;
					break;
				}else{
					$result = true;
				}
			}
		}
		
		echo json_encode(
			array(
				'status' => $result,
				'code' 	 => 200,
				'message'=> "Data berhasil di migrasi",
			)
		);
	}

	private function get_last_id($table, $field){
		$db = $this->load->database('default', TRUE);
		$db->select(" MAX(".$field.") as id ");
		$db->from($table);
		$id = $db->get();
		if ($id->num_rows() > 0) {
			return $id->row()->id;
		}else{
			return 1;
		}
	}
}
