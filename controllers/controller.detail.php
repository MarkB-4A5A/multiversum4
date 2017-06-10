<?php

require('model/dbhandler.php');
require('model/model.detail.php');


class Detail implements createPage {
	private $detailModel;

	public function __construct($fullUrl) {
		$this->detailModel = new DetailService($fullUrl);
	}

	public function createPage() {
		$product = $this->detailModel->getProductFromUrl();
		include('pages/detail/detail.php');
	}
}

$this->currentClass = new Detail($this->fullUrl);

