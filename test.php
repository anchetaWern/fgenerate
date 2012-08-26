
<div id="container"></div>
<script src="js/mustache.js"></script>
<script src="js/jquery18.js"></script>

<script id="input_text" type="text/html">
	<input type="text" name="{{name}}" class="{{#classes}}{{.}} {{/classes}}"/>
</script><!--#input_text-->

<script>
var classes = {
'name' : 'wern',
'classes' : ['a','b','c']
};

var html = Mustache.to_html($('#input_text').html(), classes);
$('#container').html(html);
</script>
