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
    var database = $.trim($('#db').val());
    var tbl      = $(this).attr('name');

    if($(this).attr('checked')){

      if($('#'+tbl).length == 0){

        var field_container = $('#fields');
        var new_container   = $("<div>").addClass("fields_container").attr("id" , tbl);
        var table_header    = $("<span>").attr({"class" : "tbl_header"}).text(tbl);

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
              var new_box = $("<input>").attr({"type" : "checkbox", "name" : field_name, "class" : "fields", "data-field" : tbl + "." + field_name})
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
    }else{
      
      if($('#fields').children().length == 0){
        $('#fields, #fields_label').hide();
      }
      
      removeTableFields(tbl);
      $('#' + tbl).remove();
    }
    
  });

  var removeTableFields = function(tableID){
    $('#' + tableID + ' input[type=checkbox]').each(function(){
      var data_field = $(this).data('field');
      var query = "div[data-field='" + data_field + "']";
      $('#form').find(query).remove();
    });
  };



  $('#fields').on('click', '.fields', function(){
    var form_container = $('#form');

    var fragment = document.createDocumentFragment();


    var input = $(this);
    var data_id = input.data('id');
    var data_table   = input.data('table');
    var data_field   = data_table + "." + data_id;

    if($(this).attr('checked')){  
    
      if(check_elementID(data_id)){
        data_id = get_elementID(data_id);
      }

      var data_default = input.data('default');
      var data_key     = input.data('key');
      var data_length  = input.data('length');
      var data_type    = $.trim(input.data('type'));
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
        'data_index' : data_index,
        'data_field' : data_field
      };

      var content;
      var content_data = {
        'label_id' : data_id + data_type,
        'input_id' : data_id,
        'data_field' : data_field
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

	
    }else{
      console.log(data_field);
      var query = "div[data-field='" + data_field + "']";
      $('#form').find(query).remove();
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
        update_selectoptions_data(current_field_index, field_id);
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

  function update_selectoptions_data(current_field_index, field_id){
    var options_data = $.trim($('#select_options_data').val());
    var options_data_o = JSON.parse(options_data);

    var fragment = document.createDocumentFragment();
    for(var prop in options_data_o){
      var data = options_data_o[prop];
      for(var n = 0; len = data.length, n < len; n++){

        if(prop === 'values'){//values contains the values that will be used in the options
          var option_value = options_data_o[prop][n];
          var option = $("<option>").val(option_value).text(option_value);
        }
       
      }
    }
  }



  $('#form_customizer').on('change', '#data_type', function(){
    var field_type = $(this).val();

    //change fields in the form customizer
    $('#form_customizer .control-group').hide();
    $('.all_type').show();
    $('.' + field_type).show();
    $('.no_' + field_type).hide();

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

  $('.modal-footer').on('click', '#btn_updatefield', function(){
    var query = $.trim($('#query').val());
    var database = $.trim($('#db').val());
    var fields_container = $('#selected_fields');
    fields_container.empty();

    var fragment = document.createDocumentFragment();

    $.post('invoker.php', {'action' : 3, 'db' : database,  'query' : query}, function(data){
      var data_obj = JSON.parse(data);
      var fields = data_obj['fields'];
      var field_len = fields.length;

      var rows = data_obj['rows'];

      window.ice =  fields;
      window.water = rows;
      for(var x =0; x < field_len; x++){
        var field_name = fields[x];
        var field_label = $("<label>");
        var field_checkbox = $("<input>").attr({"type" : "checkbox", "id" : field_name});
        var field_span = $("<span>").text(field_name);
        
        field_label.append(field_checkbox[0]);
        field_label.append(field_span[0]);

        fragment.appendChild(field_label[0]);    
      }

      fields_container.append(fragment);
    });
  });

  $('#btn_generate').on(function(){
    var new_form = $("<form>").attr({"method" : "post", "action" : form_action, "class" : "horizontal"});
  });

  $("#generate_html").click(function(){
    update_htmlstring();
  });

  var update_htmlstring = function(){
    var html_str = removeTemplateAttributes();
    $('#htmlcode').text(html_str);
  };

  var removeTemplateAttributes = function(){
    var html_str = $.trim($('#form').html());
    html_str = html_str.replace(/(contenteditable="true"|class="edit_field"|contenteditable="")/gi, "");
    return html_str;
  }

  $('#form').sortable();
