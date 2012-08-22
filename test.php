<?php
require_once('config.php');
$db = new Mysqli(HOST, USER, PASSWORD);

if($db->connect_errno){
	die('Connect Error: ' . $db->connect_errno);
}

$tables = $db->query("SELECT DISTINCT SCHEMA_NAME
    FROM INFORMATION_SCHEMA.SCHEMATA");
while($row = $tables->fetch_object()){
	echo $row->SCHEMA_NAME."<br/>";
} 
?>