<?php
//require_once('dbclass.php');
//$db = new dbclass();
//echo $db->create('tbl_categories', ['category'=>'de']);
//$db->query("INSERT INTO tbl_categories SET category='mg'");
//echo $db->update('tbl_categories', ['category'=>'tv series'], ['category_num'=>10]);

$db = new Mysqli('localhost','root','1234','filesys'); 

$query = $db->query("SELECT * FROM tbl_categories");
$rows = [];
while($row = $query->fetch_row()){
	$rows[] = $row;
}
echo json_encode($rows);
?>