<?php

require('../model/dbhandler.php');
require('../model/filehandler.php');
require('../model/HtmlGenerator.php');

class ProductService {
  public $dbhandler;
  public $htmlGenerator;
  public $filehandler;
  public $url;

  public function __construct($url) {
    $this->url = $url;
    $this->htmlGenerator = new HtmlGenerator();
    $this->filehandler = new FileHandler('/index.php');
    $this->dbhandler = new DbHandler(SERVER_NAME, DB_NAME, DB_USERNAME, DB_PASSWORD);
  }

  public function getAllProductData() {
    $result = $this->dbhandler->readData(['selectQuery' => 'SELECT * FROM products INNER JOIN brand ON products.brand_id = brand.id INNER JOIN platform ON products.platform_id = platform.id']);
    return $result;
  }

  public function getProductData() {
    $result = $this->dbhandler->readData(['selectQuery' => 'SELECT
      products.product_name AS `product name`,
      brand.brand_name AS `Brand`

      FROM products INNER JOIN brand ON products.brand_id = brand.id INNER JOIN platform ON products.platform_id = platform.id']);
    return $result;
  }

  public function CreateProduct($PostArray,$FileArray) {

    if ($PostArray !== "") {
      $a = $PostArray['brand_id'];
      $b = $PostArray['product_name'];
      $c = $PostArray['description'];
      $d = $PostArray['price'];
      $e = $PostArray['color'];
      $f = $PostArray['platform_id'];
      $g = $PostArray['resolution'];
      $h = 5;
    }

    $query = "INSERT INTO `products`
    (`brand_id`, `product_name`, `description`, `price`, `color`, `platform_id`, `resolution`, `refresh_rate_id`)
    VALUES
    ('$a','$b','$c','$d','$e','$f','$g','$h')  ";

    $insertQuery = $this->dbhandler->createdata($query);
    $afbeelding = $this->createAfbeelding($insertQuery,$FileArray, $b );
  }

  public function createAfbeelding($lastId, $FileArray, $b) {

     $name = $FileArray["Products_file"]["name"];
     $tmp_name = $FileArray["Products_file"]["tmp_name"];
     $path = preg_replace('/\s+/', '', $b) . "/";
     $location = $path . $name;

     $query = "INSERT INTO `image`(`id`,`image_url`) VALUES (NULL,'$location')";
     $result = $this->dbhandler->createdata($query);

     if ($result > 0) {
        $destination = "../css/images/" . $path;
        mkdir($destination, 0700);
        move_uploaded_file($tmp_name,"c:/xampp/htdocs/css/images/".$location);
     }

      $query = "INSERT INTO `products_has_image`(`products_id`, `image_id`) VALUES ('$lastId','$result')";
      $this->dbhandler->createdata($query);
  }

  public function createProductTable() {
    $products = $this->getProductData();
    $prefix = [];
    $suffix = [];

    $preAndSuffix = $this->dbhandler->readData(['selectQuery' => 'SELECT products.product_name, products.id FROM products']);
    foreach($preAndSuffix as $key => $value) {
      $prefix[$value['product_name']] = '<a href="/products/product/update/' . $value['id'] . '">';
      $suffix[$value['product_name']] = '</a>';
    }

    return $this->htmlGenerator->createTable($products, [], [], $prefix, $suffix, []);
  }

  public function productUpdateForm() {
    $everything = $this->dbhandler->readData(['selectQuery' => 'SELECT * FROM products WHERE products.id = ' . $this->url[2]]);
    $brand = $this->dbhandler->readData(['selectQuery' => 'SELECT brand.id, brand.brand_name FROM brand']);
    $brandSelected = $this->dbhandler->readData(['selectQuery' => 'SELECT products.brand_id AS `id` FROM products WHERE products.id = ' . $this->url[2]]);
    $return = $this->htmlGenerator->createUpdateform($everything, ['selectbox' => [$brand, $brandSelected[0]['id']]]);
    return $return;
  }

  public function createCreationForm() {
    $databaseContent = $this->dbhandler->readData(['selectQuery' => 'SELECT products.product_name,products.price,products.color,products.resolution FROM products LIMIT 0,1']);
    $databaseContentTextarea = $this->dbhandler->readData(['selectQuery' => 'SELECT products.description FROM products LIMIT 0,1']);
    $brand = $this->dbhandler->readData(['selectQuery' => 'SELECT brand.id, brand.brand_name FROM brand']);
    $platform = $this->dbhandler->readData(['selectQuery' => 'SELECT platform.id, platform.platform_name FROM platform']);
    $return = $this->htmlGenerator->createCreationForm($databaseContent, [['textarea' => $databaseContentTextarea], ['selectbox' => $platform], ['selectbox' => $brand], 'file' => ['Products_file']]);

    return $return;
  }
}
