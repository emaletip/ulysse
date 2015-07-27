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
	
	public function addOrder($post) {

		$products = $this->cartModel->listCart();
		$total_price = 0;
		
		foreach($products as $product) {
			$p = $this->contentModel->getProduct($product->product_id);
			$total_price += $product->quantity * current($p['results'])->content_price;
		}
		
		$product_json = json_encode($products);
		$product_json = str_replace('"','\\"',$product_json);
		
		$_SESSION['order']['products'] = $product_json;
		
		$delivery_address = $post['delivery_address']; 
		
		$res = $this->pdo->insert(
        'INSERT INTO `order`(`user_id`, `delivery_address`, `total_price`, `product_json`)
        VALUES (:user_id, :delivery_address, :total_price, :product_json)', array(
            ':user_id' => $_SESSION['user']->id,
            ':product_json' => $product_json,
            ':delivery_address' => $delivery_address,
            ':total_price' => $total_price,
            )
        );
        
	    return true;    
	}
	
	public function getPdo() {
		return $this->pdo;	
	}
	
	public function getList() {
		return $this->pdo->query('SELECT * FROM order;');
	}
	
 	public function getId() {
		return $this->id;
	}
	
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	
	public function getUser($id) {
		return $this->pdo->query('SELECT * FROM user WHERE id=:id;', array(':id', $id));
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
