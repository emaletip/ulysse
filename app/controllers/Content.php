<?php 

namespace app\controllers;

class Content {
    
	 private $contentModel;

	public function __construct() {
		$this->contentModel = new \app\models\Content();
		return $this;
	}

	public function getContent($id) {
		return $this->contentModel->getContent($id);
	}

	public function getList() {
        return $this->contentModel->getList();
    }
}	
