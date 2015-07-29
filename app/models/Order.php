<?php 

namespace app\models;

class Order {

	private $id;
	private $user_id;
	private $total_price;
	private $product_json; 
	private $created_date;
	private $pdo; 
	public  $cartModel; 
	public  $contentModel; 
	
	public function __construct() {
		$this->pdo = new \config\database();
		$this->cartModel = new \app\models\Cart();
		$this->contentModel = new \app\models\Content();
	}
	
	public function getOrder($id) {
		 return $this->pdo->query('SELECT * FROM `order` o JOIN `order_product` op ON op.`order_id` = o.`id` WHERE op.`id`=:id', array(':id' => (int)$id));
	}
	
	public function getOrderList() {
		 return $this->pdo->query('SELECT * FROM `order` o');
	}
		
	public function addOrder($post) {
		
		$livraison_id = $post['livraison'];
		
		$user_content_id = 0;

		$products = $this->cartModel->listCart();

		$total_price = 0;
		
		$resid = $this->pdo->query('SELECT max(id) as last_id FROM `order`;');
		$last_id = current($resid)->last_id ? current($resid)->last_id + 1 : 1;
		
		foreach($products as $product) {
			$p = $this->contentModel->getProduct($product->product_id);
			$pdt = current($p['results']);
			$res = $this->pdo->insert(
				'INSERT INTO `order_product` (`order_id`, `product_id`, `quantity`, `user_id`, `user_content_id`)
				VALUES (:order_id, :product_id, :quantity, :user_id, :user_content_id)', array(
	            ':user_id' => (int)$pdt->created_user,
	            ':product_id' => (int)$pdt->content_id,
	            ':order_id' => (int)$last_id,
	            ':quantity' => (int)$product->quantity,
	            ':user_content_id' => (int)$product->user_content_id,
	            )
	        );


	        if($product->user_content_id != 0) {
	        	$usc = $this->cartModel->getUserContent($pdt->user_content_id);
				$price = $usc[0]->content_price;
			} else {
		        $price = $pdt->content_price;
	        }
			$total_price += $product->quantity * $price;

	        $res2 = $this->pdo->update(
	        	'UPDATE `field_stock`
	        	SET `content_stock` = :new_value
	        	WHERE content_id = :content_id', array(
	        		':new_value' => (int)$pdt->content_stock - $product->quantity,
	        		':content_id' => (int)$pdt->content_id
	        	)
	        );

		}
		
		$delivery_address = $post['delivery_address']; 
		
		$res = $this->pdo->insert(
        'INSERT INTO `order`(`id`, `user_id`, `delivery_address`, `total_price`, `delivery_id`)
        VALUES (:id, :user_id, :delivery_address, :total_price, :delivery_id)', array(
            ':id' => (int)$last_id,
            ':user_id' => (int)$_SESSION['user']->id,
            ':delivery_address' => $delivery_address,
            ':total_price' => $total_price,
            ':delivery_id' => $livraison_id,
            )
        );
        
	    return $last_id;    
	}

	public function setStatus($status_id, $id) {
		return $this->pdo->update(
			'UPDATE `order_product`
			SET `delivery_status_id`=:delivery_status_id
			WHERE `id`=:id', array(
				':delivery_status_id' => $status_id,
				':id' => $id
			)
		);
	}
	
	public function getPdo() {
		return $this->pdo;	
	}
	
	public function getList() {
		return $this->pdo->query('SELECT * FROM `order`;');
	}

	public function getListOrderProduct() {
		return $this->pdo->query('SELECT * FROM `order_product`;');
	}

	public function getOrderProduct($id) {
		 return $this->pdo->query('SELECT * FROM `order_product` WHERE order_id=:order_id', 
		 							array(':order_id' => (int)$id));
	}
		
	public function getUserOrder($id) {
		 return $this->pdo->query('SELECT * FROM `order` o JOIN `order_product` op ON op.`order_id` = o.`id` WHERE op.`user_id`=:user_id', array(':user_id' => (int)$id));
	}
	
	public function getUserBuys($id) {
		return $this->pdo->query('SELECT * FROM `order` o JOIN `order_product` op ON op.`order_id` = o.`id` WHERE o.`user_id`=:user_id', array(':user_id' => (int)$id));
	}

	public function getTotalEarnings() {
		return $this->pdo->query('SELECT SUM(total_price) AS earnings FROM `order`;');
	}
	
 	public function getId() {
		return $this->id;
	}
	
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	
	public function getUser($id) {
		return $this->pdo->query('SELECT * FROM user WHERE id=:id;', array(':id' => $id));
	}
	
 	public function getUser_id() {
		return $this->user_id;
	}
	
	public function setUser_id($user_id) {
		$this->user_id = $user_id;
		return $this;
	}
	
 	public function getTotal_price() {
		return $this->total_price;
	}
	
	public function setTotal_price($total_price) {
		$this->total_price = $total_price;
		return $this;
	}
	
 	public function getProduct_json() {
		return $this->product_json;
	}
	
	public function setProduct_json($product_json) {
		$this->product_json = $product_json;
		return $this;
	}
	
 	public function getCreated_date() {
		return $this->created_date;
	}
	
	public function setCreated_date($created_date) {
		$this->created_date = $created_date;
		return $this;
	}

}	
