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
	public function getStep2() {
		
		/* Prepare Order Item */
		
		return $this->cartModel->listCart();
	}	
	public function postValidStep2() {
		
		$addresse = $_POST['delivery_first_name'] . ' ';
		$addresse .= $_POST['delivery_last_name'] . ', ';
		$addresse .= $_POST['delivery_address1'] . ', ';
		$addresse .= $_POST['delivery_address2'] != '' ? $_POST['delivery_address2'] . ', ' : '' ;
		$addresse .= $_POST['delivery_postal_code'] . ' ';
		$addresse .= $_POST['delivery_city'] . ', ';
		$addresse .= $_POST['delivery_country'] . ' ';
		
		/* MAJ ORDER */
		
		redirect('order/livraison');
				
	}
	
	public function getStep3() {
	}
	
	public function getStep4() {
	}

}