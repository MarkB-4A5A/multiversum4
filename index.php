<?php
//require the config of the page, all the globals vars are set here.
require('config.php');


require('model/Route.php');

function amountInCart() {
	if(isset($_COOKIE['multiversumCart'])) {
		$array = unserialize($_COOKIE['multiversumCart']);
		return count($array);
	} else {
		return 0;
	}
}




$route = new Route($url[0], $url);

//Landing page.
$route->addRoute('', 'controllers/controller.overview.php');

//if you go to /cart.
$route->addRoute('cart', 'controllers/controller.cart.php');

//if you go to /detail.
$route->addRoute('detail', 'controllers/controller.detail.php');

//if you go to /admin
$route->addRoute('admin', 'controllers/controller.admin.php');

//setting the ajax calls.
$route->addRoute('addProduct', 'ajax/productCart.php');
$route->addRoute('pagination', 'ajax/pagination.php');



$route->showPage();