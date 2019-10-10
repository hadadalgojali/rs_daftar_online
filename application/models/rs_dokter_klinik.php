<?php 

class rs_dokter_klinik extends CI_Model {
	protected $table 		= "rs_dokter_klinik";
	protected $database 	= "";

	public function set_database($database){
		$this->database = $database;
	}

	public function get($select = "*", $criteria = null, $order_by = "asc"){
		$this->database->select($select);
		$this->database->from($this->table);
		if ($criteria !== null) {
			$this->database->where($criteria);
		}
		return $this->database->get();
	}

	public function create($parameter){
		try {
			$this->db->insert($this->table, $parameter);
			return $this->db->affected_rows();
		} catch (Exception $e) {
			return $e;
		}
	}

	public function update($criteria, $parameter){
		try {
			$this->db->where($criteria);
			$this->db->update($this->table, $parameter);
			return $this->db->affected_rows();
		} catch (Exception $e) {
			return $e;
		}
	}

	public function delete($criteria){
		try {
			$this->db->where($criteria);
			$this->db->delete($this->table);
			return $this->db->affected_rows();
		} catch (Exception $e) {
			return $e;
		}
	}
}	