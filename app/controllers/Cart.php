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
		
		if(!is_null($id)) {
			
			/* DELETE OLD CART */
			$this->cartModel->deleteCart($id);

			foreach($_SESSION['cart'] as $cart_item) {
				for($i = 0; $i < $cart_item->quantity; $i++) {
					$addcart = $this->cartModel->addProduct($cart_item->product_id);
				}
			}
		}
		
	}
	
	public function getAddProduct($id) {
		
		if(isset($_SESSION['user'])) {
			$res = $this->cartModel->addProduct($id);
		} else {
			
			if($_SESSION['cart'] && isset($_SESSION['cart'][$id])){
				$qty = $_SESSION['cart'][$id]->quantity + 1;
			} else {
				$qty = 1;
			}
			
			$product = (object) ['product_id' => $id, 'quantity' => $qty];
			$_SESSION['cart'][$id] = $product;			
			$res = $_SESSION['cart'];
		}
		
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