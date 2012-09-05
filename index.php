
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

    <h4 id="tbl_label">Database</h4>  
    <div id="database_info">
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
    </div>
    
    <h4 id="tbl_label" style="display:none;">Tables</h4>
    <div id="tables" style="display:none;"></div>
    
    <h4 id="fields_label" style="display:none;">Fields</h4>
    <div id="fields" style="display:none;"></div>

    <h4 id="forms_label" style="display:none;">Form</h4>
    <div id="form_container" style="display:none;">
      <form id="form" class="form-horizontal">

      </form>
      <div id="form_customizer" style="display:none;">
      <h5>Customize Form Field</h5>
      <form class="form-horizontal">

        <div class="control-group all_type">
          <label for="data_type" class="control-label">Type</label>
          <div class="controls">
            <select name="data_type" id="data_type">
              <option value="text">text</option>
              <option value="email">email</option>
              <option value="url">url</option>
              <option value="hidden">hidden</option>
              <option value="select">select</option>
              <option value="radio">radio</option>
              <option value="checkbox">checkbox</option>
              <option value="textarea">textarea</option>
              <option value="number">number</option>
              <option value="date">date</option>
              <option value="datetime">datetime</option>
              <option value="week">week</option>
              <option value="time">time</option>
              <option value="range">range</option>
              <option value="button">button</option>
            </select>
          </div>
        </div>

        <div class="text number email textarea control-group">
            <label for="min_length" class="control-label">Min Length</label>
            <div class="controls">
             <input type="number" name="min_length" id="min_length" class="input-mini"/>
            </div>
        </div>

        <div class="text number email textarea control-group">
            <label for="max_length" class="control-label">Max Length</label>
            <div class="controls">
             <input type="number" name="max_length" id="max_length" class="input-mini"/>
            </div>
        </div>

        <div class="number control-group">
            <label for="input_step" class="control-label">Step</label>
            <div class="controls">
             <input type="number" name="input_step" id="input_step" class="input-mini"/>
            </div>
        </div>

        <div class="select control-group">
            <label for="input_multiple" class="control-label">Multiple</label>
            <div class="controls">
              <input type="checkbox" name="input_multiple" id="input_multiple"/>
            </div>
        </div>

        <div class="text radio checkbox select textarea control-group">
            <label for="help_text" class="control-label">Help Text</label>
            <div class="controls">
              <input type="text" name="help_text" id="help_text" class="input-xlarge"/>
            </div>
        </div>

        <div class="text email control-group">
            <label for="pattern_text" class="control-label">Pattern</label>
            <div class="controls">
              <input type="text" name="pattern_text" id="pattern_text" class="input-xlarge"/>
            </div>
        </div>

        <div class="text select textarea control-group email url number">
            <label for="input_required" class="control-label">Required</label>
            <div class="controls">
              <input type="checkbox" name="input_required" id="input_required"/>
            </div>
        </div>

        <div class="text select textarea control-group">
            <label for="input_readonly" class="control-label">Read-only</label>
            <div class="controls">
              <input type="checkbox" name="input_readonly" id="input_readonly"/>
            </div>
        </div>

        <div class="text email number radio checkbox select textarea control-group">
            <label for="field_data" class="control-label">Field Data</label>
            <div class="controls">
              <textarea id="field_data" name="field_data" style="margin-left: 0px; margin-right: 0px; width: 363px; "></textarea>
               <a data-toggle="modal" href="#data_fetcher" class="btn">Data</a>
            </div>
        </div>

        <div class="text email control-group">    
            <label for="placeholder_text" class="control-label">Placeholder</label>
            <div class="controls">
             <input type="text" name="placeholder_text" id="placeholder_text" class="input-xlarge"/>
            </div>
        </div>

        <div class="select control-group">    
            <label for="select_options_text" class="control-label">Select Options</label>
            <div class="controls">
              <textarea id="select_options_data" name="select_options_data" style="margin-left: 0px; margin-right: 0px; width: 363px; "></textarea>
               <a data-toggle="modal" href="#data_fetcher" class="btn">Data</a>
            </div>
        </div>

        <div class="text email control-group">
            <label for="datalist_id" class="control-label">Datalist ID</label>
            <div class="controls">
              <input type="text" name="datalist_id" id="datalist_id"/>
            </div>
          </div>

          <div class="text email control-group">
            <label for="datalist_data" class="control-label">Datalist Data</label>
            <div class="controls">
              <textarea id="datalist_data" name="datalist_data" style="margin-left: 0px; margin-right: 0px; width: 363px;"></textarea>
              <a data-toggle="modal" href="#data_fetcher" class="btn">Data</a>
            </div>
        </div>
            
        <div class="text email number radio checkbox select textarea control-group">    
            <label for="classes" class="control-label">Classes</label>
            <div class="controls">
              <input type="text" name="classes" id="classes" class="input-large"/>
            </div>
        </div>    
      </form>
    </div><!--/#form_customizer-->
    </div>
    <button type="button" id="btn_generate" class="btn" style="display:none;">Generate</buton>

    <div id="database_data">
      <label for="text_database">Database</label>
      <select name="text_database" id="text_database">
        <option value=""></option>
      </select> 
    </div><!--/#database_data-->

  </div><!--/.container-->

  <div id="data_fetcher" class="modal hide fade in" style="display: none; ">
      <div class="modal-header">
        <a class="close" data-dismiss="modal">x</a>
        <h3>Fetch Data</h3>
      </div>
      <div class="modal-body">
          
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
            <input type="text" id="{{input_id}}" class="edit_field" autocomplete="off">
          </div>
      </div>
  </script><!--/#input_text-->

  <script id="input_email" type="text/html">
    <div class="control-group">
        <label class="control-label" contenteditable="true">{{input_id}}</label>
          <div class="controls">
            <input type="email" id="{{input_id}}" class="edit_field" autocomplete="off">
          </div>
      </div>
  </script><!--/#input_email-->

  <script id="input_url" type="text/html">
    <div class="control-group">
        <label class="control-label" contenteditable="true">{{input_id}}</label>
          <div class="controls">
            <input type="url" id="{{input_id}}" class="edit_field" autocomplete="off">
          </div>
      </div>
  </script><!--/#input_url-->

  <script id="input_hidden" type="text/html">
    <div class="control-group">
        <label class="control-label" contenteditable="true">{{input_id}}</label>
          <div class="controls">
            <input type="hidden" id="{{input_id}}" class="edit_field">
          </div>
      </div>
  </script><!--/#input_hidden-->


  <script id="input_checkbox" type="text/html">
    <div class="control-group">
     <div class="controls">
      <label class="checkbox control-label" contenteditable="true">
        <input type="checkbox" id="{{input_id}}" name="{{name}}" class="edit_field" value="{{value}}">
          {{input_id}}
      </label>
      </div>
    </div>
  </script><!--/#input_checkbox-->


  <script id="input_radio" type="text/html">
    <div class="control-group">
      <div class="controls">
      <label class="radio control-label" contenteditable="true">
        <input type="radio" id="{{input_id}}" name="{{name}}" class="edit_field" value="{{value}}">
          {{input_id}}
      </label>
      </div>
    </div>
  </script><!--/#input_radio-->


  <script id="input_textarea" type="text/html">
    <div class="control-group">
      <label class="control-label edit_field" contenteditable="true">{{input_id}}</label>
      <div class="controls">
        <textarea id="{{input_id}}" rows="{{rows}}"></textarea>
      </div>
    </div>
  </script><!--/#input_textarea-->

  <script id="input_number" type="text/html">
    <div class="control-group">
        <label class="control-label" contenteditable="true">{{input_id}}</label>
          <div class="controls">
            <input type="number" id="{{input_id}}" class="edit_field">
          </div>
      </div>
  </script><!--/#input_number-->



  <script id="input_select" type="text/html">
   <div class="control-group">
    <label class="control-label edit_field" contenteditable="true">{{input_id}}</label>
      <div class="controls">
      <select id="{{input_id}}">
      {{#option}}
        <option value="{{option_text}}">{{option_text}}</option>
      {{/option}}
      </select>
      </div>
    </div>
  </script><!--/#input_select-->


   <script id="input_date" type="text/html">
    <div class="control-group">
        <label class="control-label" contenteditable="true">{{input_id}}</label>
          <div class="controls">
            <input type="date" id="{{input_id}}" class="edit_field">
          </div>
      </div>
  </script><!--/#input_date-->

    <script id="input_datetime" type="text/html">
    <div class="control-group">
        <label class="control-label" contenteditable="true">{{input_id}}</label>
          <div class="controls">
            <input type="datetime" id="{{input_id}}" class="edit_field">
          </div>
      </div>
  </script><!--/#input_datetime-->


    <script id="input_week" type="text/html">
    <div class="control-group">
        <label class="control-label" contenteditable="true">{{input_id}}</label>
          <div class="controls">
            <input type="week" id="{{input_id}}" class="edit_field">
          </div>
      </div>
  </script><!--/#input_week-->

    <script id="input_time" type="text/html">
    <div class="control-group">
        <label class="control-label" contenteditable="true">{{input_id}}</label>
          <div class="controls">
            <input type="time" id="{{input_id}}" class="edit_field">
          </div>
      </div>
  </script><!--/#input_time-->

    <script id="input_range" type="text/html">
    <div class="control-group">
        <label class="control-label" contenteditable="true">{{input_id}}</label>
          <div class="controls">
            <input type="range" id="{{input_id}}" class="edit_field">
          </div>
      </div>
  </script><!--/#input_range-->

   <script id="input_button" type="text/html">
      <button type="submit" class="btn">{{input_value}}</button>
  </script><!--/#input_button-->

  <script id="input_helptext" type="text/html">
   <span class="help-inline" contenteditable>{{help_text}}</span>
  </script><!--/#input_helptext-->

  <script id="input_datalist" type="text/html">
    <datalist id="{{id}}">
    </datalist>
  </script><!--/#input_datalist-->

  <script>
  var input_config = {
    current_field_index : ''
  };

  var form_fields = {
    fields : []
  };

  $('#btn_connect').click(function(){
    var database = $.trim($('#db').val());
    var tbl_container = $('#tables');
    tbl_container.empty();
    $('#fields, #form').empty();
    
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

      if($('#'+tbl).length == 0){

        var field_container = $('#fields');
        var new_container   = $("<div>").addClass("fields_container");
        var table_header    = $("<span>").attr({"class" : "tbl_header", "id" : tbl}).text(tbl);

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
    }
    
  });



  $('#fields').on('click', '.fields', function(){
    if($(this).attr('checked')){  
      var form_container = $('#form');

      var fragment = document.createDocumentFragment();


      var input = $(this);
      var data_id = input.data('id');

      if(check_elementID(data_id)){
        data_id = get_elementID(data_id);
      }

      var data_default = input.data('default');
      var data_key     = input.data('key');
      var data_length  = input.data('length');
      var data_type    = $.trim(input.data('type'));
      var data_table   = input.data('table');
      var data_index   = form_container.children().length; 

    

      var form_type;
      if(textbox.indexOf(data_type) > -1){
        form_type = "text";
      }else if(textarea.indexOf(data_type) > - 1){
        form_type = "textarea";
      }else if(radio.indexOf(data_type) > -1){
        form_type = "radio";
      }


      var input_data = {
        'data_id' : data_id,
        'data_default' : data_default,
        'data_key' : data_key,
        'data_length' : data_length,
        'data_type' : data_type,
        'data_table' : data_table,
        'form_type' : form_type,
        'data_index' : data_index
      };

      var content;
      var content_data = {
        'label_id' : data_id + data_type,
        'input_id' : data_id
      };
      
      content = Mustache.to_html($('#input_' + form_type).html(), content_data);
      
      form_container.append(content);

      var current_element = $('#' + data_id);
      current_element.data(input_data);
      $('#form_container, #forms_label').show();

      //push new elements into the temporary location
      var number_of_fields = form_container.children().length - 1;
      form_fields.fields[number_of_fields] = {};
      form_fields.fields[number_of_fields]['data'] = input_data;

      form_fields.fields[number_of_fields].required = false;
      form_fields.fields[number_of_fields].readonly = false;

     
      $(current_element[0].attributes).each(function(){
        var attr = this.nodeName; 
        var attr_value = this.nodeValue;
        form_fields.fields[number_of_fields][attr] = attr_value;
      });


    }
  });

  function check_elementID(id){//checks if element with the same id already exists in the current form
    var len = $('#'+id).length;
    return !!len; //returns true if there is atleast 1 element with the id specified
  }

  function get_elementID(id){//returns a new element ID
    var len = $('#'+id).length;
    return id + "_" + len;
  }


  $('#form_container').on('click', '.edit_field', function(){
    var form_customizer = $('#form_customizer');
    form_customizer.show();


    var input = $(this);
    var data_id = input.attr('id');
    var data_default = input.data('default');
    var data_key     = input.data('key');
    var data_length  = input.data('length');
    var data_type    = input.data('type');
    var data_table   = input.data('table');
    var form_type    = input.data('form_type');
    var field_index  = input.data('data_index'); 

    $('#form_customizer .control-group').hide();
    $('.all_type').show();
    $('.' + form_type).show();
    
    $('#data_type').val(form_type);
    $('#max_length').val(data_length);

    //will be used later on as index for the field storage
    input_config.current_field_index = field_index;

    var classes = form_fields.fields[field_index].class;
    var placeholder = form_fields.fields[field_index].placeholder;
    var help_text = form_fields.fields[field_index].help_text;
    var required = form_fields.fields[field_index].required;
    var readonly = form_fields.fields[field_index].readonly;
    var pattern = form_fields.fields[field_index].pattern;
    var datalist_id = form_fields.fields[field_index].datalist_id;
    var datalist_data = form_fields.fields[field_index].datalist_data;
    var field_data = form_fields.fields[field_index].field_data;

    //supply data to form fields
    $('#data_type').val(form_type);
    $('#classes').val(classes);
    $('#placeholder_text').val(placeholder);
    $('#help_text').val(help_text);
    $('#input_required').attr('checked' , required);
    $('#input_readonly').attr('checked', readonly);
    $('#pattern_text').val(pattern);
    $('#datalist_id').val(datalist_id);
    $('#datalist_data').val(datalist_data);
    $('#field_data').val(field_data);


   
  });
  
  $('#form_customizer').on('click', 'input', function(){
    var id = $(this).attr('id');
    var current_field_index = input_config.current_field_index;
    var field_id = form_fields.fields[current_field_index].id;

    switch(id){
       //prerequisite: disabled, readonly is unchecked
      case 'input_required':
        update_required(current_field_index, field_id);
      break;

      //prerequisite: required is unchecked
      case 'input_readonly':
        update_readonly(current_field_index, field_id);
      break;

    }
  });

  $('#form_customizer').on('blur', 'input, textarea, select', function(){
    var id = $(this).attr('id');
    var current_field_index = input_config.current_field_index;
    var field_id = form_fields.fields[current_field_index].id;

    switch(id){
      case 'classes':
        
        update_input_class(current_field_index, field_id);
      break;

      case 'datalist_id':
        update_input_datalist(current_field_index, field_id);
      break;

      case 'datalist_data':
        update_datalist_data(current_field_index, field_id);
      break;


      case 'select_options_data':
      break;

      case 'placeholder_text':
        update_input_placeholder(current_field_index, field_id);
      break;

      case 'field_data':
        update_fielddata(current_field_index, field_id);
      break;

      case 'help_text':
        update_input_helptext(current_field_index, field_id);
      break;

      case 'max_length':
      break;

      case 'min_length':
      break;

      case 'data_type':
      break;

      //only for text, email
      case 'pattern_text':
        update_input_patterns(current_field_index, field_id);
      break;

      //only for number
      case 'input_step':
      break;

      //only for select
      case 'input_multiple':
      break;
    }
  });

  function update_input_class(current_field_index, field_id){
      var classes = $.trim($('#classes').val());
      $('#' + field_id).attr('class', classes);
      form_fields.fields[current_field_index].class = classes;
  }

  function update_input_placeholder(current_field_index, field_id){
    var placeholder = $.trim($('#placeholder_text').val());
    $('#' + field_id).attr('placeholder', placeholder);
    form_fields.fields[current_field_index].placeholder = placeholder;
  }
  
  function update_input_helptext(current_field_index, field_id){
    var help_text = $.trim($('#help_text').val()); 

    var input_helptext = $('#' + field_id).siblings('.help-inline');
    var number_of_helptext = input_helptext.length;
    if(number_of_helptext == 0){
      var content_data = {
        'help_text' : help_text
      };
        
      var content = Mustache.to_html($('#input_helptext').html(), content_data);
      $(content).insertAfter('#' + field_id);

    }else{
      input_helptext.text(help_text);
    }

    form_fields.fields[current_field_index].help_text = help_text;
  }

  function update_required(current_field_index, field_id){
    var required = !!$('#input_required').attr('checked');
    $('#' + field_id).attr('required', required);
    form_fields.fields[current_field_index].required = required;
  }

  function update_readonly(current_field_index, field_id){
    var readonly = !!$('#input_readonly').attr('checked');
    $('#' + field_id).attr('readonly', readonly);
    form_fields.fields[current_field_index].readonly = readonly;
  }

   function update_input_patterns(current_field_index, field_id){
      var pattern = $.trim($('#pattern_text').val());
      $('#' + field_id).attr('pattern', pattern);
      form_fields.fields[current_field_index].pattern = pattern;
  }

  function update_input_datalist(current_field_index, field_id){
    var datalist_id = $.trim($('#datalist_id').val());

    var content_data = {
      'id' : datalist_id
    };
    var content = Mustache.to_html($('#input_datalist').html(), content_data);
    $(content).insertAfter('#' + field_id);
    $('#' + field_id).attr('list', datalist_id);
    form_fields.fields[current_field_index].datalist_id = datalist_id;
  }

  function update_datalist_data(current_field_index, field_id){
    var datalist_id = form_fields.fields[current_field_index].datalist_id;
    var datalist_data = $.trim($('#datalist_data').val())
    var datalist_data_r = datalist_data.split(" ");
    var fragment = document.createDocumentFragment();


    for(var x = 0; len = datalist_data_r.length, x < len; x++){
      var value = datalist_data_r[x];
      var option = $("<option>").attr("value", value).text(value);
      fragment.appendChild(option[0]);
    }

    $('#' + datalist_id).empty();
    $('#' + datalist_id).append(fragment);
    form_fields.fields[current_field_index].datalist_data = datalist_data;
  }

  function update_fielddata(current_field_index, field_id){
    var field_data = $.trim($('#field_data').val());
    var field_data_o = JSON.parse(field_data);

    $('#' + field_id).data(field_data_o);
    form_fields.fields[current_field_index].field_data = field_data;
  }



  $('#form_customizer').on('change', '#data_type', function(){
    var field_type = $(this).val();

    //change fields in the form customizer
    $('#form_customizer .control-group').hide();
    $('.all_type').show();
    $('.'+field_type).show();

    //change the current field into selected field
    var input_index = input_config.current_field_index;

    var input_data = form_fields.fields[input_index];
    var input_id = input_data.id;
    var data = input_data.data;
    var data_type = data.data_type;
    var form_type = data.form_type;

    var content_data = {
        'label_id' : input_id + data_type,
        'input_id' : input_id
    };

      
    content = Mustache.to_html($('#input_' + field_type).html(), content_data);
    $('#'+input_id).parents('.control-group').replaceWith(content);

    form_fields.fields[input_index].type = field_type;
    form_fields.fields[input_index].data.form_type = field_type;

    $('#' + input_id).data(data).addClass('edit_field');
    
    update_input_class(input_index, input_id);
  });

  $('#btn_generate').on(function(){
    var new_form = $("<form>").attr({"method" : "post", "action" : form_action, "class" : "horizontal"});
  });
  </script>
</html>
