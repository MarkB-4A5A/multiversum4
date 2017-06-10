<?php

class DetailService {
	private $dbhandler; 
	public $fullUrl;
	private $productId;

	public function __construct($fullUrl) {
		$this->dbhandler = new DbHandler(SERVER_NAME, DB_NAME, DB_USERNAME, DB_PASSWORD);
		$this->fullUrl = $fullUrl;
		if(!isset($this->fullUrl[1]) || $this->fullUrl[1] == '') {
			die('no id has been set');
		} else {
			$this->productId = $this->fullUrl[1];
		}
	}

	public function getProductFromUrl() {
		$product = $this->dbhandler->readData(['selectQuery' => '
			SELECT 
				products.id AS products_id,
				products.brand_id,
				products.description,
				products.product_name,
				products.price,
				products.color,
				products.platform_id,
				products.resolution,
				products.refresh_rate_id,
				brand.id AS brand_id,
				brand.brand_name,
				platform.id AS platform_id,
				platform.platform_name,
				refresh_rate.id,
				refresh_rate.rate
			FROM
				products
			INNER JOIN 
				brand 
			ON
				products.brand_id = brand.id 
			INNER JOIN
				platform
			ON 
				products.platform_id = platform.id
			INNER JOIN
				refresh_rate
			ON
				products.refresh_rate_id = refresh_rate.id	
			WHERE products.id = ' . $this->productId]);
		if(is_object($product) || empty($product)) {
			die('not a good url');
		}

		return $product;
	}

	public function showImages() {
		$images = $this->dbhandler->readData(['selectQuery' => 'SELECT * FROM `products_has_image` INNER JOIN image ON products_has_image.image_id = image.id WHERE products_has_image.products_id = ' . $this->productId]);
		$string = '';
		$count = 0;
		foreach($images as $row) {
			if($count == 0) {
				$string .= '<img style="width:100%;" src="/css/images/' . $row['image_url'] . '">';
			} else {
				$string .= '<img style="width:100px;" src="/css/images/' . $row['image_url'] . '">';
			}
			
			$count++;
		}

		return $string;
	}

}