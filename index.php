<!DOCTYPE html>
<?php
require_once('conn.php');

$databases = $db->query("
    SELECT DISTINCT SCHEMA_NAME
    FROM INFORMATION_SCHEMA.SCHEMATA
");
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
        <button type="button" id="btn_connect" class="btn btn-primary">Connect</button>
      </form>
    </div><!--/#database_info-->
  
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

          <div class="number range control-group">
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

          <div class="all_type no_hidden control-group">
              <label for="help_text" class="control-label">Help Text</label>
              <div class="controls">
                <input type="text" name="help_text" id="help_text" class="input-xlarge"/>
              </div>
          </div>

          <div class="text email url control-group">
              <label for="pattern_text" class="control-label">Pattern</label>
              <div class="controls">
                <input type="text" name="pattern_text" id="pattern_text" class="input-xlarge"/>
              </div>
          </div>

          <div class="text textarea email url control-group">
              <label for="input_required" class="control-label">Required</label>
              <div class="controls">
                <input type="checkbox" name="input_required" id="input_required"/>
              </div>
          </div>

          <div class="text textarea email url control-group">
              <label for="input_readonly" class="control-label">Read-only</label>
              <div class="controls">
                <input type="checkbox" name="input_readonly" id="input_readonly"/>
              </div>
          </div>

          <div class="all_type control-group">
              <label for="field_data" class="control-label">Field Data</label>
              <div class="controls">
                <textarea id="field_data" name="field_data" style="margin-left: 0px; margin-right: 0px; width: 363px; "></textarea>
                 <a data-toggle="modal" href="#data_fetcher" class="btn">Data</a>
              </div>
          </div>

          <div class="text email url control-group">    
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

          <div class="text url control-group">
              <label for="datalist_id" class="control-label">Datalist ID</label>
              <div class="controls">
                <input type="text" name="datalist_id" id="datalist_id"/>
              </div>
          </div>

          <div class="text url control-group">
              <label for="datalist_data" class="control-label">Datalist Data</label>
              <div class="controls">
                <textarea id="datalist_data" name="datalist_data" style="margin-left: 0px; margin-right: 0px; width: 363px;"></textarea>
                <a data-toggle="modal" href="#data_fetcher" class="btn">Data</a>
              </div>
          </div>
              
          <div class="all_type control-group">    
              <label for="classes" class="control-label">Classes</label>
              <div class="controls">
                <input type="text" name="classes" id="classes" class="input-large"/>
              </div>
          </div>    
        </form>

        <button type="button" id="generate_html" class="btn btn-success">Generate HTML</button>
      </div><!--/#form_customizer-->

  
    </div><!--/#form_container-->

    <h5>HTML</h5>
    <div id="html_container">
      <div style="position:relative;">

      <pre id="htmlcode"></pre>
    </div><!--/#html_container-->

  </div><!--/#main_container-->

  <div id="data_fetcher" class="modal hide fade in" style="display: none; ">
    <div class="modal-header">
      <a class="close" data-dismiss="modal">x</a>
      <h3>Fetch Data</h3>
    </div>
    <div class="modal-body">
      <div class="all_type control-group">
          <label for="field_data" class="control-label">Query</label>
          <div class="controls">
            <textarea id="query" name="query" style="margin: 0px 0px 9px; width: 516px; height: 171px;"></textarea>


          </div>
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

  
  <script>
  $("#generate_html").click(function(){
    update_htmlstring();
  });

  var update_htmlstring = function(){
    var html_str = removeTemplateAttributes();
  	$('#htmlcode').text(html_str);
  };

  var removeTemplateAttributes = function(){
    var html_str = $('#form').html();
    html_str = html_str.replace(/(contenteditable="true"|class="edit_field"|contenteditable="")/gi, "");
    return html_str;
  }
  </script>

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
    <div class="control-group" style="display:none;">
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

  <script id="input_time" type="text/html">
    <div class="control-group">
      <label class="control-label" contenteditable="true">{{input_id}}</label>
      <div class="controls">
        <input type="time" id="{{input_id}}" class="edit_field input-medium">
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

  <script src="js/main.js"></script>
</html>
