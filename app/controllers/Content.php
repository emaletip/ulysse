<?php 

namespace app\controllers;

class Content {
    
	 private $contentModel;

	public function __construct() {
		$this->contentModel = new \app\models\Content();
		return $this;
	}

	public function getProduct($id) {
		return $this->contentModel->getProduct($id);
	}

	public function getProductList() {
        return $this->contentModel->getProductList();
    }
}	
