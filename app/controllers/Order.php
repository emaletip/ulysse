<?php 

namespace app\controllers;

class Order {

	public $cartModel;
	public $orderModel;
	public $contentModel;

	public function __construct() {
		$this->orderModel = new \app\models\Order();
		$this->cartModel = new \app\models\Cart();
		$this->contentModel = new \app\models\Content();
		return $this;
	}

	public function getList() {
		return $this->orderModel->getList();
	}
	
	
	public function getStep1() {
		$cart = array();

		if(isset($_SESSION['user'])){
			$cart = $this->cartModel->listCart();
		} else if(isset($_SESSION['cart'])){
			$cart = $_SESSION['cart'];
		}	
		return $cart;
	}
	
	public function getStep2() {
		
		/* Prepare Order Item */
		$_SESSION['order'] = array();
		
		return $this->cartModel->listCart();
	}	
	public function postValidStep2() {
		$adresse = $_POST['delivery_first_name'] . ' ';
		$ddresse .= $_POST['delivery_last_name'] . ', ';
		$adresse .= $_POST['delivery_address1'] . ', ';
		$adresse .= $_POST['delivery_address2'] != '' ? $_POST['delivery_address2'] . ', ' : '' ;
		$adresse .= $_POST['delivery_postal_code'] . ' ';
		$adresse .= $_POST['delivery_city'] . ', ';
		$adresse .= $_POST['delivery_country'] . ' ';
		
		/* MAJ ORDER */		
		$_SESSION['order']['delivery_address'] = $adresse;
		
		redirect('order/livraison');
	}
	
	public function postValidStep3() {
		
		/* MAJ ORDER */
		$_SESSION['order']['livraison'] = $_POST['livraison'];
		
		redirect('order/paiement');
				
	}
	public function postValidStep4() {
		
		$cb['nb'] 	  = $_POST['number'];
		$cb['date']   = $_POST['month'] . '/' . $_POST['year'] ;
		$cb['crypto'] = $_POST['cryptogramme'];

		/* MAJ ORDER */
		if(!is_valid_cb($cb)){
			show_flash(false,false,'<b>Erreur ! </b> Le numéro de carte est invalide.',false,false);
			redirect(parent_url());
		}
		
		$_SESSION['order_id'] = $this->orderModel->addOrder($_SESSION['order']);

		redirect('order/confirmation');
				
	}
	
	public function getStep3() {
	}
	
	public function getStep4() {
	}
	
	public function getStep5() {

		$order = $_SESSION['order'];
		$order['products'] = $this->orderModel->getOrderProduct($_SESSION['order_id']);
		$this->cartModel->deleteCart($_SESSION['user']->id);
		return $order;
	}

}	
