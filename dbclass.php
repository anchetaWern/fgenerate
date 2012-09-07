<?php
class dbclass{
	private	$host = 'localhost';
	private $user = 'root';
	private $password = '1234';
	private $database = 'filesys';
	private $query_string = '';
	private $fields_length = 0;
	private $db;
	
	public function __construct(){

		$this->db = new Mysqli($this->host, $this->user, $this->password, $this->database); 
		if ($this->db->connect_errno){
		    die('Connect Error: ' . $db->connect_errno);
		}
	}

	public function create($table, $fields_r, $q_str = 0){
		$index = 1;
		$this->query_string = "INSERT INTO " . $table . " SET ";
		$this->fields_length = count($fields_r);
		foreach($fields_r as $field=>$value){
			$this->query_string.= $field . " = " . "'$value'";
			if($index < $this->fields_length){
				$this->query_string .= ", ";
			}
			$index++;

		}

		$query = $this->db->query($this->query_string);
		return $query;
	}

	public function update($table, $fields_r, $where, $q_str = 0){
		$index = 1;
		$key = key($where);
		$current = current($where);
		$this->query_string = "UPDATE " . $table . " SET ";
		$this->fields_length = count($fields_r);
		foreach($fields_r as $field=>$value){
			$this->query_string.= $field . " = " . "'$value'";
			if($index < $this->fields_length){
				$this->query_string .= ", ";
			}
			
			$index++;

		}

		$this->query_string .= " WHERE ". $key . " = " . "'$current'";
		
		$query = $this->db->query($this->query_string);
		return $query;
		
	}


	public function query($query_string){
		$query = $this->db->query($query_string);
		return $query;
	}
}
?>