<?php

class App_employee extends CI_Model {
	protected $table 		= "app_employee";
	protected $database 	= "";

	public function set_database($database){
		$this->database = $database;
	}

	public function get($select = "*", $criteria = null, $limit = null, $start = null){
		$this->database->select($select);
		$this->database->from($this->table);
		if ($criteria !== null && $criteria !== "") {
			$this->database->where($criteria);
		}

		if (isset($limit) && isset($start)) {
			if ($limit != "" && $start != "") {
				$this->database->limit($limit, $start);
			}
		}

		return $this->database->get();
	}

	public function get_with_job($select = "*", $criteria = null, $limit = null, $start = null){
		$this->database->select($select);
		$this->database->from($this->table);
		if ($criteria !== null && $criteria !== "") {
			$this->database->where($criteria);
		}

		$this->database->join("app_job", " app_job.job_id = ".$this->table.".job_id ", "LEFT");
		if (isset($limit) && isset($start)) {
			if ($limit != "" && $start != "") {
				$this->database->limit($limit, $start);
			}
		}

		return $this->database->get();
	}

	public function get_with_join($select = "*", $criteria = null, $limit = null, $start = null){
		$this->database->select($select);
		$this->database->from($this->table);
		if ($criteria !== null && $criteria !== "") {
			$this->database->where($criteria);
		}

		$this->database->join("app_job", " app_job.job_id = ".$this->table.".job_id ", "LEFT");
		$this->database->join("app_user", " app_user.employee_id = ".$this->table.".employee_id ", "LEFT");
		$this->database->join("app_role", " app_role.role_id = app_user.role_id ", "LEFT");
		if (isset($limit) && isset($start)) {
			if ($limit != "" && $start != "") {
				$this->database->limit($limit, $start);
			}
		}

		return $this->database->get();
	}

	public function create($parameter){
		try {
			$this->database->insert($this->table, $parameter);
			return array(
				'result'	=> $this->database->affected_rows(),
				'error'	  => $this->database->error(),
			);
		} catch (Exception $e) {
			return $e;
		}
	}

	public function update($criteria, $parameter){
		try {
			$this->database->where($criteria);
			$this->database->update($this->table, $parameter);
			return array(
				'result'	=> $this->database->affected_rows(),
				'error'	  => $this->database->error(),
			);
		} catch (Exception $e) {
			return $e;
		}
	}

	public function delete($criteria){
		try {
			$this->database->where($criteria);
			$this->database->delete($this->table);
			return array(
				'result'	=> $this->database->affected_rows(),
				'error'	  => $this->database->error(),
			);
		} catch (Exception $e) {
			return $e;
		}
	}
}
