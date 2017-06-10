<?php

require('model/model.cart.php');


class Cart implements createPage {
	public $cartModel;

	public function __construct() {
		$this->cartModel = new CartService();
	}

	public function createPage() {
		if($this->cartModel->cookie->cookieIsset() && !empty($this->cartModel->cookie->readCookie())) {
			$content = $this->cartModel->createPageContent($this->cartModel->readCookieContent());
		} else {
			$content = '';
		}

		if(isset($_POST['payment'])) {
			$this->cartModel->payBill();
		}

		print_r($_POST);

		include('pages/cart/cart.php');
	}
}

$this->currentClass = new Cart();
