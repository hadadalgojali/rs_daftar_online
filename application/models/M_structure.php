<?php

class M_structure extends CI_Model {
	protected $database 	= "";

	public function set_database($database){
		$this->database = $database;
	}

	public function get($criteria = ''){
		return $this->database->query("
			SELECT
			COLUMN_NAME as column_name, DATA_TYPE as data_type
			FROM
				INFORMATION_SCHEMA.COLUMNS
			$criteria
		");
	}

}
