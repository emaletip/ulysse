<?php 

namespace app\controllers;

class Order {

	public $orderModel;

	public function __construct() {
		$this->orderModel = new \app\models\Order();
		return $this;
	}

	public function getList() {
		return $this->orderModel->getList();
	}
	

}	
