
<!DOCTYPE html>
<?php
require_once('conn.php');

$databases = $db->query("SELECT DISTINCT SCHEMA_NAME
    FROM INFORMATION_SCHEMA.SCHEMATA");
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>fgenerate</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="libs/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css"/>
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
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
      <button type="button" id="btn_connect" class="btn btn-primary">Connect</button>
      </p>
    </form>
    
    <h4 id="tbl_label" style="display:none;">Tables</h4>
    <div id="tables" style="display:none;"></div>
    
    <h4 id="fields_label" style="display:none;">Fields</h4>
    <div id="fields" style="display:none;"></div>

    <h4 id="forms_label" style="display:none;">Form</h4>
    <div id="form_container" style="display:none;">
      
    </div>
    <button type="button" id="btn_generate" class="btn" style="display:none;">Generate</buton>

    <div id="database_data">
      <label for="text_database">Database</label>
      <select name="text_database" id="text_database">
        <option value=""></option>
      </select> 
    </div><!--/#database_data-->

  </div><!--/.container-->

  <div id="formfield_customizer" class="modal hide fade in" style="display: none; ">
      <div class="modal-header">
        <a class="close" data-dismiss="modal">x</a>
        <h3>Customize Form Field</h3>
      </div>
      <div class="modal-body">
	      <label for="data_type">Type</label>
	      <select name="data_type" id="data_type">
	        <option value="text">text</option>
	        <option value="select">select</option>
	        <option value="radio">radio</option>
	        <option value="checkbox">checkbox</option>
	        <option value="textarea">textarea</option>
	        <option value="button">button</option>
	      </select>

	      <div class="text number email textarea">
		      <label for="min_length">Min Length</label>
		      <input type="text" name="min_length" id="min_length" class="input-mini"/>
	 	  </div>

	 	  <div class="text number email textarea">
		      <label for="max_length">Max Length</label>
		      <input type="text" name="max_length" id="max_length" class="input-mini"/>
		  </div>

		  <div class="text radio checkbox select textarea">
		      <label for="help_text">Help Text</label>
		      <input type="text" name="help_text" id="help_text" class="input-xlarge"/>
	      </div>

	      <div class="text email number radio checkbox select textarea">
		      <label for="field_data">Field Data</label>
		      <textarea id="field_data" name="field_data" style="margin-left: 0px; margin-right: 0px; width: 363px; "></textarea>
		      <button type="button" id="btn_fielddata" class="btn">Data</button>
		  </div>

		  <div class="text email">    
		      <label for="placeholder_text">Placeholder</label>
		      <input type="text" name="placeholder_text" id="placeholder_text" class="input-xlarge"/>
		   </div>

		  <div class="text email number radio checkbox select textarea">    
		      <label for="options_text">Options</label>
		      <input type="text" name="options_text" id="options_text" class="input-xlarge"/>
		  </div>

		  <div class="select">    
		      <label for="select_options_text">Options</label>
		      <textarea id="select_options_data" name="select_options_data" style="margin-left: 0px; margin-right: 0px; width: 363px; "></textarea>
		      <button type="button" id="btn_optionsddata" class="btn">Data</button>
		  </div>

		  <div class="text email">
		      <label for="datalist_id">Datalist ID</label>
		      <input type="text" name="datalist_id" id="datalist_id"/>
	      </div>

	      <div class="text email">
		      <label for="datalist_data">Datalist Data</label>
		      <textarea id="datalist_data" name="datalist_data" style="margin-left: 0px; margin-right: 0px; width: 363px; "></textarea>
		      <button type="button" id="btn_datalistdata" class="btn">Data</button>
		  </div>
		      
		  <div class="text email number radio checkbox select textarea">    
		      <label for="classes">Classes</label>
		      <input type="text" name="classes" id="classes" class="input-large"/>
		  </div>    
      </div><!--/.modal_body-->

      <div class="modal-footer">
        <a href="#" id="btn_updatefield" class="btn btn-success">Update</a>
        <a href="#" class="btn" data-dismiss="modal">Close</a>
      </div>
  </div>
</body>


  <script src="js/jquery18.js"></script>
  <script src="libs/bootstrap/js/bootstrap.min.js"></script>
  <script src="js/mustache.js"></script>
  <script src="js/config.js"></script>


  <!--templates-->
  <script id="input_text" type="text/html">
    <div class="control-group">
        <label class="control-label" contenteditable="true">{{input_id}}</label>
          <div class="controls">
            <input type="text" id="{{input_id}}" class="edit_field {{#classes}}{{.}} {{/classes}}" placeholder="{{placeholder}}" {{#options}}{{.}} {{/options}}>
          </div>
      </div>
  </script><!--/#input_text-->


  <script id="input_checkbox" type="text/html">
    <label class="checkbox {{#classes}}{{.}} {{/classes}}" contenteditable="true">
      <input type="checkbox" name="{{name}}" class="edit_field" value="{{value}}" {{#options}}{{.}} {{/options}}>
        {{input_id}}
    </label>
  </script><!--/#input_checkbox-->


  <script id="input_radio" type="text/html">
    <label class="radio {{#classes}}{{.}} {{/classes}}" contenteditable="true">
      <input type="radio" name="{{name}}" class="edit_field" value="{{value}}" {{#options}}{{.}} {{/options}}>
        {{input_id}}
    </label>
  </script><!--/#input_radio-->


  <script id="input_textarea" type="text/html">
    <label class="{{#classes}}{{.}} {{/classes}}" class="edit_field" contenteditable="true">{{input_id}}</label>
    <textarea rows="{{rows}}"></textarea>
  </script><!--/#input_textarea-->


  <script id="input_select" type="text/html">
    <label class="{{#classes}}{{.}} {{/classes}}" class="edit_field" contenteditable="true">{{input_id}}</label>
    <select>
    {{#option}}
      <option value="{{option_text}}">{{option_text}}</option>
    {{/option}}
    </select>
  </script><!--/#input_select-->


  <script id="input_prepend" type="text/html">
    <label class="{{#classes}}{{.}} {{/classes}}" contenteditable="true">{{input_id}}</label>
    <div class="input-prepend">
        <span class="add-on">{{prepend_text}}</span><input class="span2 {{#classes}}{{.}} {{/classes}}" id="{{input_id}}" size="{{size}}" type="{{type}}" placeholder="{{placeholder}}">
      </div>
  </script><!--/#input_prepend-->


  <script id="input_append" type="text/html">
    <label class="{{#classes}}{{.}} {{/classes}}" contenteditable="true">{{input_id}}</label>
    <div class="input-append">
        <input class="span2 {{#classes}}{{.}} {{/classes}}" id="{{input_id}}" size="{{size}}" type="{{type}}" placeholder="{{placeholder}}"><span class="add-on">{{append_text}}</span>
    </div>
  </script><!--/#input_append-->


  <script id="input_combined" type="text/html">
    <label class="{{#classes}}{{.}} {{/classes}}" contenteditable="true">{{input_id}}</label>
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
          $('#tables').show();
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
          $('#fields, #fields_label').show();
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

      var content;
      var content_data = {
        'label_id' : data_id + data_type,
        'input_id' : data_id
      };
      
      content = Mustache.to_html($('#input_' + form_type).html(), content_data);
      
      
      $('#form_container').append(content);
      $('#form_container, #forms_label').show();

    }
  });


  $('#form_container').on('click', '.edit_field', function(){
    $('#formfield_customizer').modal('show');
  });

  $('#formfield_customizer').on('click', '#btn_updatefield', function(){

  });

  $('#formfield_customizer').on('change', '#data_type', function(){
    var field_type = $(this).val();

    $(".modal-body div").hide();
    $('.'+field_type).show();

  });

  $('#btn_generate').on(function(){
    var new_form = $("<form>").attr({"method" : "post", "action" : form_action, "class" : "horizontal"});
  });
  </script>
</html>
