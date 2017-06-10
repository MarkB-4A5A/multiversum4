<?php

require('model/dbhandler.php');
require('model/model.overview.php');

class Overview implements createPage {
	private $overviewModel;

	public function __construct() {
		$this->overviewModel = new OverviewService();
	}

	public function createPage() {
		$products = $this->overviewModel->createPageContent(0);
		$pagination = $this->overviewModel->createPagination();
		include('pages/overview/overview.php');
	}

}

$this->currentClass = new Overview();