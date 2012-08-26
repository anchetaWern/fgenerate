<?php
require_once('conn.php');

$databases = $db->query("SELECT DISTINCT SCHEMA_NAME
    FROM INFORMATION_SCHEMA.SCHEMATA");
?>
<head>
	<title>fgenerate</title>
	
	<link href="libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="css/style.css"/>
</head>

<body>
    <div class="navigation">
	   <div class="navbar navbar-inverse navbar-fixed-top">
	      <div class="navbar-inner">
	        <div class="container">
	          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </a>
	          <a class="brand" href="#">fgenerate</a>
	          <div class="nav-collapse collapse">
	            <ul class="nav">
	              
	            </ul>
	          </div><!--/.nav-collapse -->
	        </div>
	      </div>
	    </div>
    </div><!--/.navigation-->

	<div id="main_container" class="container">
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
			<button type="button" id="btn_connect" class="btn">Connect</button>
			</p>
		</form>
		
		<h4 id="tbl_label" style="display:none;">Tables</h4>
		<div id="tables"></div>
		
		<h4 id="fields_label" style="display:none;">Fields</h4>
		<div id="fields"></div>

		<h4 id="forms_label" style="display:none;">Form</h4>
		<div id="form_container">
			
		</div>
		<button type="button" id="btn_generate" class="btn" style="display:none;">Generate</buton>

	</div><!--/.container-->
</body>


<script src="js/jquery18.js"></script>
<script src="libs/bootstrap/js/bootstrap.min.js"></script>
<script src="js/mustache.js"></script>
<script src="js/config.js"></script>


<!--templates-->
<script id="input_text" type="text/html">
	<div class="control-group">
      <label class="control-label" for="{{id}}">{{label}}</label>
        <div class="controls">
          <input type="text" id="{{id}}" class="{{#classes}}{{.}} {{/classes}}" placeholder="{{placeholder}}" {{#options}}{{.}} {{/options}}>
        </div>
    </div>
</script><!--/#input_text-->


<script id="input_checkbox" type="text/html">
	<label class="checkbox {{#classes}}{{.}} {{/classes}}">
	  <input type="checkbox" name="{{name}}" value="{{value}}" {{#options}}{{.}} {{/options}}>
	  	{{label}}
	</label>
</script><!--/#input_checkbox-->


<script id="input_radio" type="text/html">
	<label class="radio {{#classes}}{{.}} {{/classes}}">
	  <input type="radio" name="{{name}}" value="{{value}}" {{#options}}{{.}} {{/options}}>
	  	{{label}}
	</label>
</script><!--/#input_radio-->


<script id="input_textarea" type="text/html">
	<textarea rows="{{rows}}"></textarea>
</script><!--/#input_textarea-->


<script id="input_select" type="text/html">
	<select>
	{{#option}}
	  <option value="{{option_text}}">{{option_text}}</option>
	{{/option}}
	</select>
</script><!--/#input_select-->


<script id="input_prepend" type="text/html">
	<div class="input-prepend">
  		<span class="add-on">{{prepend_text}}</span><input class="span2 {{#classes}}{{.}} {{/classes}}" id="{{id}}" size="{{size}}" type="{{type}}" placeholder="{{placeholder}}">
  	</div>
</script><!--/#input_prepend-->


<script id="input_append" type="text/html">
	<div class="input-append">
	  	<input class="span2 {{#classes}}{{.}} {{/classes}}" id="{{id}}" size="{{size}}" type="{{type}}" placeholder="{{placeholder}}"><span class="add-on">{{append_text}}</span>
	</div>
</script><!--/#input_append-->


<script id="input_combined" type="text/html">
	<div class="input-prepend input-append">
	 	<span class="add-on {{#append_classes}}{{.}} {{/append_classes}}">{{prepend_text}}</span><input class="span2" id="{{id}}" size="{{size}}" type="{{type}}" placeholder="{{placeholder}}"><span class="add-on {{#append_classes}}{{.}} {{/append_classes}}">{{append_text}}</span>
	</div>
</script><!--/#input_combined-->


<script>
$('#btn_connect').click(function(){
	var database = $.trim($('#db').val());
	var tbl_container = $('#tables');
	tbl_container.empty();
	$('#fields, #form_container').empty();
	
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
					var new_lbl = $("<label>");
					var new_lbl_txt = $("<span>").text(current_table);
					
					new_li.append(new_box);
					new_box.wrap(new_lbl);
					new_lbl_txt.insertAfter(new_box);
					
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

					var new_lbl = $("<label>");
					var new_lbl_txt = $("<span>").text(field_name);
					
					new_li.append(new_box);
					new_box.wrap(new_lbl);
					new_lbl_txt.insertAfter(new_box);

					fragment.appendChild(new_li[0]);

				}

				new_container[0].appendChild(fragment);
				field_container[0].appendChild(new_container[0]);
				$('#fields_label').show();
			}
		);
	}
	
});


$('#fields').on('click', '.fields', function(){
	if($(this).attr('checked')){	
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
		}else{ //no default: bring up the customization form

		}
		
		control_group[0].appendChild(form_label[0]);
		control_group[0].appendChild(controls[0]);
		controls[0].appendChild(input[0]);

		fragment.appendChild(control_group[0]);

		$('#form_container').append(fragment);
		$('#forms_label').show();

	}
});

$('#btn_generate').on(function(){
	var new_form = $("<form>").attr({"method" : "post", "action" : form_action, "class" : "horizontal"});
});

</script>


