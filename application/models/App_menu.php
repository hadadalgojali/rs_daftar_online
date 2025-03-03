<?php 

class App_menu extends CI_Model {
	protected $table 		= "app_menu";
	protected $database 	= "";

	public function set_database($database){
		$this->database = $database;
	}

	public function get($select = "*", $criteria = null){
		$this->database->select($select);
		$this->database->from($this->table);
		if ($criteria !== null) {
			$this->database->where($criteria);
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