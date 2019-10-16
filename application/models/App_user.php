<?php 

class App_user extends CI_Model {
	protected $table 		= "app_user";
	protected $database 	= "";

	public function set_database($database){
		$this->database = $database;
	}

	public function get($select = "*", $criteria = null, $limit = null, $start = null){
		$this->database->select($select);
		$this->database->from($this->table);
		if ($criteria !== null) {
			$this->database->where($criteria);
		}

		if (isset($limit) && isset($start)) {
			if ($limit != "" && $start != "") {
				$this->database->limit($limit, $start);
			}
		}
		return $this->database->get();
	}

	public function get_with_employee($select = "*", $criteria = null, $limit = null, $start = null){
		$this->database->select($select);
		$this->database->from($this->table);
		$this->database->join("app_employee", " app_employee.employee_id = ".$this->table.".employee_id", "INNER");
		if ($criteria !== null) {
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
			return $this->database->affected_rows();
		} catch (Exception $e) {
			return $e;
		}
	}

	public function update($criteria, $parameter){
		try {
			$this->database->where($criteria);
			$this->database->update($this->table, $parameter);
			return $this->database->affected_rows();
		} catch (Exception $e) {
			return $e;
		}
	}

	public function delete($criteria){
		try {
			$this->database->where($criteria);
			$this->database->delete($this->table);
			return $this->database->affected_rows();
		} catch (Exception $e) {
			return $e;
		}
	}
}	