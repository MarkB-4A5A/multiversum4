<?php

interface createPage {
	public function createPage();
}

class Route {
	private $url;
	private $fullUrl;
	private $currentClass;

	public function __construct($url, $fullUrl) {
		$this->url = $url;
		$this->fullUrl = $fullUrl;
	}

	public function addRoute($pageName, $controllerPath) {
		if($this->url == $pageName){
			require($controllerPath);
		}
	}

	public function showPage() {
		if(isset($this->currentClass) && $this->currentClass instanceof createPage) {
			$this->currentClass->createPage();
		}
	}
}
