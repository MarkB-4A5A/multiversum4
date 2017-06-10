<?php

require_once('model/model.cart.php');


class ProductCart extends CartService {

	public function __construct() {
		$this->htmlgenerator = new HtmlGenerator();
		$this->dbhandler = new DbHandler(SERVER_NAME, DB_NAME, DB_USERNAME, DB_PASSWORD);
		$this->cookie = new CookieHandler('multiversumCart');
		if(!$this->cookie->cookieIsset()) {
			$this->cookie->SetCookie([]);
		}
	}

	public function addToCart() {
		$this->cookie->updateCookie([$_POST['productName'] => ['id' => $_POST['id'], 'amount' => 1]]);
	}

	public function deleteFromCart() {
		$this->cookie->deleteCookieItem($_POST['productName']);
	}

	public function updateAmount() {
		$cookie = $this->cookie->readCookie();
		echo $_POST['amount'];
		if($_POST['amount'] > 10) {
			die();
		} else {
			$cookie[$_POST['productName']]['amount'] = $_POST['amount'];
			$this->cookie->updateCookie($cookie);
		}
	}

	public function executeAction($action) {
		switch($action) {
			case 'add':
				return $this->addToCart();
			break;
			case 'delete':
				return $this->deleteFromCart();
			break;
			case 'updateAmount':
				return $this->updateAmount();
			break;
			default:
			die(false);
		}
	}
}

$productCart = new ProductCart();

if(isset($_POST['action']) && $_POST['action'] == 'timeout'){
	echo json_encode(['count' => count($productCart->cookie->readCookie()), 'content' => $productCart->createPageContent($productCart->readCookieContent())]);
} elseif(isset($_POST['action']) && $_POST['action'] != 'timeout') {
	echo json_encode(['content' => $productCart->executeAction($_POST['action'])]);
} else {
	die();
}
