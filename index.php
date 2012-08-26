<?php
require_once('conn.php');

$databases = $db->query("SELECT DISTINCT SCHEMA_NAME
    FROM INFORMATION_SCHEMA.SCHEMATA");
?>
<head>
	<link rel="stylesheet" href="css/style.css"/>
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
	
	<h4 id="tbl_label" style="display:none;">Tables</h4>
	<div id="tables"></div>
	
	<h4 id="fields_label" style="display:none;">Fields</h4>
	<div id="fields"></div>
	<div id="form_container">
		<button type="submit" id="btn_submit" class="btn">Submit</button>
	</div>
	<button type="button" id="btn_generate" style="display:none;">Generate</buton>
</body>

<script src="js/jquery18.js"></script>
<script src="js/config.js"></script>
<script>


$('#btn_connect').click(function(){
	var database = $.trim($('#db').val());
	var tbl_container = $('#tables');
	tbl_container.empty();
	
	var fragment = document.createDocumentFragment();
	
	var ul = $("<ul>");
	fragment.appendChild(ul[0]);
	
	$('#tbl_label').show();
	$.post('invoker.php', 
			{'action' : 1, 'db' : database},
			function(data){
				var tables = JSON.parse(data);
				
				for(var t in tables){
					var current_table = tables[t]['tbl_name'];
					
					var new_li  = $("<li>");
					var new_box = $("<input>").attr({"type" : "checkbox", "name" : current_table, "class" : "tables"});
					var new_lbl = $("<span>").text(current_table);
					
					new_li.append(new_box);
					new_lbl.insertAfter(new_box);
					
					
					fragment.appendChild(new_li[0]);
				}
				
				tbl_container[0].appendChild(fragment);
			}
	);
});


$('#tables').on('click', '.tables', function(){
	if($(this).attr('checked')){
		var database = $.trim($('#db').val());
		var tbl      = $(this).attr('name');

		var field_container = $('#fields');
		var new_container   = $("<div>").addClass("fields_container");
		var table_header    = $("<span>").addClass("tbl_header").text(tbl);

		new_container[0].appendChild(table_header[0]);

		var fragment = document.createDocumentFragment();

		$.post('invoker.php',
			{'action' : 2, 'db' : database, 'table' : tbl},
			function(data){
				var fields = JSON.parse(data);
				for(var f in fields){
					var field        = fields[f];
					var field_name   = field['field_name'];
					var data_type    = field['data_type'];
					var default_data = field['default_data'];
					var column_key   = field['column_key'];
					var nullable     = field['nullable'];
					var length       = field['length'];

					var new_li = $("<li>");
					var new_box = $("<input>").attr({"type" : "checkbox", "name" : field_name, "class" : "fields"})
						.data({
							"table" : tbl, "type" : data_type, "default" : default_data, "key" : column_key, 
							"nullable" : nullable, "length" : length, "id" : field_name
						});

					var new_lbl = $("<span>").text(field_name);
					
					new_li.append(new_box);
					new_lbl.insertAfter(new_box);
					
					
					fragment.appendChild(new_li[0]);

				}

				new_container[0].appendChild(fragment);
				field_container[0].appendChild(new_container[0]);
			}
		);
	}
	
});


$('#fields').on('click', '.fields', function(){
	var form_container = $('#form_container');
	var fragment = document.createDocumentFragment();

	var data_id = $(this).data('id');
	var data_default = $(this).data('default');
	var data_key     = $(this).data('key');
	var data_length  = $(this).data('length');
	var data_type    = $(this).data('type');
	var data_table   = $(this).data('table');

	var form_type;
	if(textbox.indexOf(data_type) > -1){
		form_type = "text";
	}else if(textarea.indexOf(data_type) > - 1){
		form_type = "textarea";
	}else if(radio.indexOf(data_type) > -1){
		form_type = "radio";
	}

	var control_group = $("<div>").addClass('control-group');
	var form_label = $("<label>").attr({"for" : data_id, "class" : "control-label"}).text(data_id);
	var controls;
	var input;

	if(form_type === "text" || form_type === "radio"){
		controls = $("<div>").addClass('controls');
		input = $("<input>").attr({"type" : form_type, "id" : data_id, "name" : data_id});
	}else if(form_type === "textarea"){
		input = $("<textarea>");
	}else{//no default: bring up the customization form

	}
	
	fragment.appendChild(control_group);
	fragment.appendChild(form_label[0]);
	fragment.appendChild(controls);
	fragment.appendChild(input[0]);

	$(fragment).insertBefore($('#btn_submit'));


});

$('#btn_generate').on(function(){
	var new_form = $("<form>").attr({"method" : "post", "action" : form_action, "class" : "horizontal"});
});

</script>
