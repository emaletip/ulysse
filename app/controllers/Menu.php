<?php 

namespace app\controllers;

class Menu {

	public $menuModel;

	public function __construct() {
		$this->menuModel = new \app\models\Menu();
		return $this;
	}

	public function getList() {
		return $this->menuModel->getList();
	}
	

}	
