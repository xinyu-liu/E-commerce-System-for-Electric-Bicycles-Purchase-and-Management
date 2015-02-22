<?php
class Transaction_model extends CI_Model{
	public function __construct(){
		$this->load->database();
	}

	public function start_transaction(){
		$this->db->query('START TRANSACTION');
	}
	
	public function roll_back(){
		$this->db->query('ROLLBACK');
	}

	public function commit(){
		$this->db->query('COMMIT');
	}
}
?>