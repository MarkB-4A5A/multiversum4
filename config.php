<?php
//Setting all the global variables so we can use them later in the webstite.

//Database settings
define('SERVER_NAME', 'localhost');
define('DB_NAME', 'multiversum');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');

//Rewritten url structure.
$url[0] = '';
if(isset($_GET['url']) && $_GET['url'] != '')
$url = explode('/',$_GET['url']);

//including some files we need later in the website.