<?php 

class App_employee extends CI_Model {
	protected $table 		= "App_employee";
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