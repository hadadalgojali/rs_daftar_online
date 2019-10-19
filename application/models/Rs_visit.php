<?php 

class Rs_visit extends CI_Model {
	protected $table 		= "rs_visit";
	protected $database 	= "";

	public function set_database($database){
		$this->database = $database;
	}

	public function get($select = "*", $criteria = null){
		$this->database->select($select);
		$this->database->from($this->table);
		if ($criteria !== null && $criteria !== '') {
			$this->database->where($criteria);
		}
		return $this->database->get();
	}

	public function get_with_relation($select = "*", $criteria = null){
		$this->database->select($select);
		$this->database->from($this->table);
		if ($criteria !== null && $criteria !== '') {
			$this->database->where($criteria);
		}
		
		$this->database->join("rs_unit", " rs_unit.unit_id = ".$this->table.".unit_id ", "INNER");
		$this->database->join("rs_patient", " rs_patient.patient_id = ".$this->table.".patient_id ", "INNER");
		$this->database->join("rs_customer", " rs_customer.customer_id = ".$this->table.".customer_id ", "INNER");
		$this->database->join("app_employee", " app_employee.employee_id = ".$this->table.".dokter_id ", "LEFT");
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