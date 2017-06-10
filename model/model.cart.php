<?php
require('model/cookie.class.php');
require('model/dbhandler.php');
require('model/HtmlGenerator.php');
require('vendor/autoload.php');

class CartService {
	public $cookie;
	public $dbhandler;
	public $htmlgenerator;
	public $cookieValue;
	public $mollie;
	public $payment;

	public function __construct() {
		$this->mollie = new Mollie_API_Client;
		$this->mollie->setApiKey("test_35tEr8UmabEJHqmFr7WhuGgmhpWexx");
		$this->htmlgenerator = new HtmlGenerator();
		$this->cookie = new CookieHandler('multiversumCart');
		$this->dbhandler = new DbHandler(SERVER_NAME, DB_NAME, DB_USERNAME, DB_PASSWORD);
		$this->cookieValue = $this->cookie->readCookie();
	}

	public function showImages($productId) {
		$images = $this->dbhandler->readData(['selectQuery' => 'SELECT * FROM `products_has_image` INNER JOIN image ON products_has_image.image_id = image.id WHERE products_has_image.products_id = ' . $productId . ' LIMIT 0,1']);
		$string = '';
		foreach($images as $row) {
			$string .= '<img style="width:100px; height:100px;" src="/css/images/' . $row['image_url'] . '">';
		}

		return $string;
	}

	public function payBill() {
		$cookie = $this->cookie->readCookie();
		if(is_array($cookie) && empty($cookie)) {
			die('no content in the shopping cart');
		}

		$array = [];
		$count = 0;
		foreach($cookie as $key => $value) {
			if($value['amount'] > 10) {
				die('something went wrong');
			} else {
				$productPrice = $this->dbhandler->readData(['selectQuery' => 'SELECT products.id, products.price FROM products WHERE id = ' . $value['id']]);
				if(is_object($productPrice) || empty($productPrice)) {
					die('something went wrong');
				}
				$array[$count] = $value['amount'] * $productPrice[0]['price'];
			}
			$count++;
		}

		$total = 0;

		for($i = 0; $i < count($array); $i++) {
			 $total += $array[$i];
		}

		$this->payment = $this->mollie->payments->create(array(
			"amount"      => round($total, 2),
			"description" => ":P",
			"redirectUrl" => "http://localhost/cart?userid="
		));


		// $payment = $mollie->payments->get($payment->id);
		header('location:' . $this->payment->getPaymentUrl());
	}

	public function readCookieContent() {
		$query = 'SELECT * FROM products WHERE id = ';
		$cookieItems = $this->cookie->readCookie();
		$count = 0;
		foreach($cookieItems as $key => $value) {
			if($count == 0) {
				$query .= $value['id'];
			} else {
				$query .= ' OR id = ' . $value['id'];
			}
			$count++;
		}

		return $this->dbhandler->readData(['selectQuery' => $query]);
	}

	public function createOptions($selected = 1) {
		$array = [];
		$secondArray;
		for($i = 1; $i < 11; $i++) {
			$array[$i] = [$i, $i];
		}
		$return  = $this->htmlgenerator->createOptions($array, $selected);
		return $return;
	}

	function createPageContent($array) {
		$string = '';
		if(is_object($array)) {
			$string = 'There is no content in the shopping cart anymore';
			return $string;
		}

		$cookieValue = $this->cookie->readCookie();

        foreach($array as $key => $value) {
					$price = round($value['price'], 2);
        	$string .= '<div class="product_container">';
        		$string .= '<div class="col-6 col-m-6">';
         			$string .= $this->showImages($value['id']);
         			$string .= '<a href="/detail/' . $value['id'] . '">' . $value['product_name'] . '</a>';
          		$string .= '</div>';
          		$string .= '<div class="col-3 col-m-3">';
							$string .= '<input type="hidden" name="price" value="' . $value['price'] . '">';
          			$string .= '<div>Aantal: <select class="onchange" onchange="changePrice(); changeAmount(' . "'" . $value['product_name'] . "'" . ', this.value)">
          					' . $this->createOptions($cookieValue[$value['product_name']]['amount']) . '</select></div>';
          			$string .= '<a onclick=" orderProduct(' . $value['id'] . ', ' . "'" . $value['product_name'] . "'" . ', ' . "'" . 'delete' . "'" . '); changePrice();" href="javascript:;"><i class="material-icons shopping_cart">delete</i>delete</a>';
          		$string .= '</div>';
          		$string .= '<div class="col-3 col-m-3 product_price">';
          		$string .= '&euro;' . str_replace(".", ",", $price);
          		$string .= '</div>';
          	$string .= '</div>';
        }

        return $string;
	}
}
