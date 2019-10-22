<?php

class M_structure extends CI_Model {
	protected $database 	= "";

	public function set_database($database){
		$this->database = $database;
	}

	public function get($criteria = '', $field = "DISTINCT(COLUMN_NAME) as column_name, DATA_TYPE as data_type, COLUMN_KEY as column_key "){

		return $this->database->query("
			SELECT
			$field
			FROM
				INFORMATION_SCHEMA.COLUMNS
			$criteria
		");
	}

	public function get_data($select, $table, $criteria = null){
		$this->database->select($select, false);
		$this->database->from($table);
		if ($criteria !== null) {
			$this->database->where($criteria);			
		}

		return $this->database->get();
	}

	public function insert($table, $parameter){
		try {
			$this->database->insert($table, $parameter);
			return $this->database->affected_rows();
		} catch (Exception $e) {
			return $e;
		}
	}
}
