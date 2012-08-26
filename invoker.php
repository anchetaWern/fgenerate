<?php
require_once('config.php');

$action = $_POST['action'];
$database = $_POST['db'];

$dbt = new Mysqli(HOST, USER, PASSWORD, $database); 
		
if($dbt->connect_errno){
	die('Connect Error: ' . $dbt->connect_errno);
}

switch($action){
	case 1: //get tables
		
		$tables = [];
		$get_tables = $dbt->query("SELECT DISTINCT TABLE_NAME 
			FROM INFORMATION_SCHEMA.TABLES 
			WHERE TABLE_SCHEMA = '$database'");
	
		
		if($get_tables->num_rows > 0){
			while($row = $get_tables->fetch_object()){
				$tables[] = array('tbl_name'=>$row->TABLE_NAME);
			}
		}
		
		echo json_encode($tables);

	break;
	
	case 2: //get fields
		$table = $_POST['table'];
		
		$fields = [];
		$get_fields = $dbt->query("SELECT DISTINCT COLUMN_NAME, TABLE_NAME, DATA_TYPE, 
			COLUMN_DEFAULT, COLUMN_KEY, IS_NULLABLE, CHARACTER_OCTET_LENGTH
			FROM INFORMATION_SCHEMA.COLUMNS
			WHERE TABLE_NAME = '$table' AND TABLE_SCHEMA='$database'
			");
		
		if($get_fields->num_rows > 0){
			while($row = $get_fields->fetch_object()){
				$fields[] = array(
					'field_name'=>$row->COLUMN_NAME,
					'data_type'=>$row->DATA_TYPE, 'default_data'=>$row->COLUMN_DEFAULT,
					'column_key'=>$row->COLUMN_KEY, 'nullable'=>$row->IS_NULLABLE,
					'length'=>$row->CHARACTER_OCTET_LENGTH
				);
			}
		}
		
		echo json_encode($fields);
	
	break;
	
}
?>