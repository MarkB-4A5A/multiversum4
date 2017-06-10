<?php

class OverviewService {
	private $dbhandler;

	public function __construct() {
		$this->dbhandler = new DbHandler(SERVER_NAME, DB_NAME, DB_USERNAME, DB_PASSWORD);
	}

	public function readProducts($start) {
		$products = $this->dbhandler->readData(['selectQuery' => 'SELECT * FROM products LIMIT ' . $start . ',10']);
		return $products;
	}

	public function getImage($id) {
		$images = $this->dbhandler->readData(['selectQuery' => 'SELECT * FROM `products_has_image` INNER JOIN image ON products_has_image.image_id = image.id WHERE products_has_image.products_id = ' . $id . ' LIMIT 0,1']);
  		return '<img class="image_overview" src="/css/images/' . $images[0]['image_url'] . '">';
	}

	public function createPagination() {
		$total = $this->dbhandler->readData(['selectQuery' => 'SELECT COUNT(*) FROM products']);
		$string = '';
		for($i = 0; $i < ceil($total[0]['COUNT(*)']) / 10; $i++) {
			$int = $i + 1;
			$string .= '<a onclick="pagination(' . $i . ')" href="javascript:;">' . $int  . '</a>';
		}
		return $string;
	}

	public function createPageContent($pageNumber) {
		$secondPageNumber = $pageNumber * 10;
		$outcome = $this->readProducts($secondPageNumber);
		$string = '';
		for($i = 0; $i < count($outcome); $i++) {
      $string .= '<article class="col-4 col-m-6 col-d-4 content_product">';
      $string .= "<a href='/detail/" . $outcome[$i]['id'] . "' >" . $this->getImage($i + 1) . "</a>";
      $string .= '<a href="/detail/' . $outcome[$i]['id'] . '"><header><h2>' . $outcome[$i]['product_name'] . '</h2></header></a>';
      $string .= "<p>&euro; " . $outcome[$i]['price'] . "</p>";
      $string .= '<a onclick="orderProduct(' . $outcome[$i]['id'] . ', ' . "'" . $outcome[$i]['product_name'] . "'" . ', ' . "'" . 'add' . "'" . ')" class="bestel" href="javascript:;">Bestel</a>';
      $string .= "</article>";
		}
      return $string;
	}
}
