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
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE TABLE_SCHEMA='$database'");
		
		if($get_tables->num_rows > 0){
			while($row = $get_tables->fetch_object()){
				$tables[] = array('tbl_name'=>$row->TABLE_NAME);
			}
		}
		
		echo json_encode($tables);

	break;
}
?>