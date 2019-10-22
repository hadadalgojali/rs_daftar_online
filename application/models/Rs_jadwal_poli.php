<?php

class Rs_jadwal_poli extends CI_Model {
	protected $table 		= "rs_jadwal_poli";
	protected $database 	= "";

	public function set_database($database){
		$this->database = $database;
	}

	public function get($select = "*", $criteria = null, $limit = null, $start = null, $order_by = "asc"){
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

	public function get_with_join($select = "*", $criteria = null, $limit = null, $start = null, $order_by = "asc"){
		$this->database->select($select);
		$this->database->from($this->table);
		$this->database->join("app_employee", "app_employee.employee_id = ".$this->table.".dokter_id", "inner");
		$this->database->join("app_employee", "app_employee.employee_id = ".$this->table.".dokter_id", "inner");
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
