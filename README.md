FGenerate
==========

This app is used for generating and customizing html forms based on tables and fields from MySql database.


##Tech Stack

- Mustache - used for templating
- jQuery - DOM manipulation
- Twitter Bootstrap


##How To Use

Copy the fgenerate folder into your webroot.

Open up ```config.php``` and change the database information:

```
<?php
define('HOST', 'localhost');
define('USER', 'root');
define('PASSWORD', '1234');
?>
```

Navigate to ```127.0.0.1:8020/fgenerate``` change the following address to match the configuration in your machine.

If the database info that you supplied is correct you will see something like the one below once you click on the connect button:

![fgenerate](fgenerate/blob/master/assets/fgenerate.PNG)


Then start selecting the tables that you're going to use for the form and then the fields for the tables.

![fields](fgenerate/blob/master/assets/fields.PNG)

Once you're done with that you can start customizing the form to your liking.

![customizeform](fgenerate/blob/master/assets/customize.PNG)


##Defaults

Here are some of the defaults in form generation that I used on this app:

```
- submit - automatically generated for each form

- textbox
	- varchar
	- date, datetime, timestamp
	- int, small int, medium int, big int
	- double, decimal, float

- textarea
	- tiny text, text, medium text, long text
	- blob, medium blob, long blob
	

- password
 	- manually set by the user

- radio button
	- char
	- tiny int

- checkbox
 	- manually set by the user

- select
	- manually set by the user
```

You can customize the defaults by editing the ```config.js``` file:

```
var textbox = [
				'varchar', 'date', 'datetime', 'timestamp', 'int', 
				'smallint', 'mediumint', 'bigint', 'double', 'decimal', 'float'
			];
var textarea = ['tinytext', 'text', 'mediumtext', 'longtext', 'blob', 'mediumblob', 'longblob'];
var radio = ['char', 'tinyint'];
var button_type = "submit"; //possible values: button, submit
var button_value = "Submit"; 

var txt_sizes = [13, 23, 26];
```

Here are some of the defaults for form customization:

```
text
 -min
 -max
 -help
 -data attachments
 -placeholder
 -options
 -datalist id
 -datalist data

select
 -options
 -help text
 -data

radio/checkbox
 -data
 -options
 -help text
```


##Todo

There's still a lot of things that needs to be done for this project. Though I started this 2 months ago I never actually got to update it again after 2-3 weeks of working with it. Here are some of the things that needs to be done:

- reordering of fields 
- deselecting fields and tables - currently the fields that are already in the form cannot be deleted when you uncheck the tables and fields which refers to the field
- defining templates - the templates are largely dependent on twitter bootstrap. I would also like to add templates for foundation and maybe let users define their own templates
- generating client-side validation code since html5 validation only works for browsers that actually support html5 form validation it would also be wise to add a separate client-side validation as well for non-supported browsers
- removing id's, classes and field attributes that are used to customize the form are still in the generated html code like ```edit_field``` and ```contenteditable="true"```
- reset everything when connecting to a database
- generating php code for populating ```datalist``` and ```select``` options
- generating JavaScript code for submitting form data to database
- generating tables (since the queries are already generated by my yellowpill project, fgenerate will only generate the skeleton of the table)






