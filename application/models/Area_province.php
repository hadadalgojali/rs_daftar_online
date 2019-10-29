<?php

class Area_province extends CI_Model {
	protected $table 		= "area_province";
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

		$this->database->order_by('province', $order_by);
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
				'result'  => $this->database->affected_rows(),
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
