<?php 

namespace app\controllers;

class Category {

	public $categoryModel;

	public function __construct() {
		$this->categoryModel = new \app\models\Category();
		return $this;
	}

	public function getList() {
		return $this->categoryModel->getList();
	}
	

}	
