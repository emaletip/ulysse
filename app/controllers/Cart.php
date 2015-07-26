<?php

namespace app\controllers;

class Cart {
	
	public $cartModel;
	private $cart;
	
	public function __construct() {
		$this->cartModel = new \app\models\Cart();
		return $this;
	}

	public function initCart() {
		$this->cart = array();
	}
	
	public function getAddProduct($id) {
		$this->cartModel->addProduct($id);
		
		$url = parent_url();

		redirect($url);
	}
	public function postDeleteProduct($id) {
		$this->cartModel->deleteProduct($id);
		$parent = str_replace('http://','',$_SERVER['HTTP_REFERER']);
		$parent = str_replace($_SERVER['HTTP_HOST'], '', $parent);
		$parent = trim(str_replace(PROJECT_DIRECTORY,'', $parent),'/');
		redirect($parent);
	}
	public function getStep1() {
		return $this->cartModel->listCart();
	}

}