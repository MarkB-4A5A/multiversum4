<?php
require('../model/model.products.php');

class Admin implements createPage {
  public $url;
  public $productsModel;

  public function __construct($url) {
    $this->productsModel = new ProductService($url);
    $this->url = $url;
  }

  public function createPage() {
    $this->url[1] = (!isset($this->url[1])) ? '' : $this->url[1];

    switch($this->url[1]) {
      case '':
        $this->read();
      break;
      case 'create':
        $this->create();
      break;
      case 'update':
        $this->update();
      break;
      default:
      $this->error();
    }
  }

  private function read() {
    $table = $this->productsModel->createProductTable();
    include('../pages/admin/read.php');

  }

  private function update() {
    $this->productsModel->productUpdateForm();
    include('../pages/admin/update.php');
  }

  public function create() {
    if(isset($_POST['submit'])) {
      // $set =  $this->productsModel->CreateProduct($_POST);

        $this->productsModel->CreateProduct($_POST,$_FILES);
    }
    $form = $this->productsModel->createCreationForm();

      include('../pages/admin/create.php');

  }

  private function delete() {

  }

  private function error() {
    echo '404 not found';
  }
}

$this->currentClass = new Admin($this->fullUrl);
