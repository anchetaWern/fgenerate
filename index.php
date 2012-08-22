<?php
require_once('conn.php');

$databases = $db->query("SELECT DISTINCT SCHEMA_NAME
    FROM INFORMATION_SCHEMA.SCHEMATA");
?>
<head>
</head>

<body>
	<form method="post" action="index.php">
		<p>
		<label for="db">Database:</label>
		<?php
		if($databases->num_rows > 0){ ?>
		<select name="db" id="db">
		<?php
		while($row = $databases->fetch_object()){
		?>
		<option value="<?php echo $row->SCHEMA_NAME; ?>"><?php echo $row->SCHEMA_NAME; ?></option>
		<?php
		}
		?> 
		</select>
		<?php
		}
		?>
		</p>
		<p>
		<input type="button" value="Connect" id="btn_connect"/>
		</p>
	</form>
	
	<div id="tables"></div>
</body>

<script src="js/jquery18.js"></script>
<script>
$('#btn_connect').click(function(){
	var database = $.trim($('#db').val());
	
	$('#tables').load('invoker.php', {'action' : 1, 'db' : database});
});
</script>
