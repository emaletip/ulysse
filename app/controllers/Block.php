<?php 

namespace app\controllers;

class Block {

	private $blockModel;

	public function __construct() {
		$this->blockModel = new \app\models\Block();
		return $this;
	}
	
	public function getList() {
		return 'block';
	}

}	
