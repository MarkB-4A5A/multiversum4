<?php
require('../config.php');
include('../model/Route.php');

$route = new Route($url[0], $url);


function amountInCart() {
	if(isset($_COOKIE['multiversumCart'])) {
		$array = unserialize($_COOKIE['multiversumCart']);
		return count($array);
	} else {
		return 0;
	}
}


$route->addRoute('product', '../controllers/controller.admin.php');

$route->showPage();
