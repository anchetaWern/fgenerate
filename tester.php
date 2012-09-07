<?php
require_once('dbclass.php');
$db = new dbclass();
//echo $db->create('tbl_categories', ['category'=>'de']);
//$db->query("INSERT INTO tbl_categories SET category='mg'");
echo $db->update('tbl_categories', ['category'=>'tv series'], ['category_num'=>10]);
?>