<?php

namespace app\controllers;

class Cart {
	
	public $cartModel;
	public $contentModel;
	private $cart;
	
	public function __construct() {
		$this->cartModel = new \app\models\Cart();
		$this->contentModel = new \app\models\Content();
		return $this;
	}

	public function initCart($id = null) {
		$this->cart = array();
	}
	
	public function postAddProduct() {
	
		$id = $_POST['content_id'];
		$user_content_id = $_POST['user_content_id'];

		$res = $this->cartModel->addProduct($id, $user_content_id);
		
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
	

}