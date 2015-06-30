<?php 

namespace app\models;

class Order {

	private $id;
	private $user_id;
	private $total_price;
	private $product_json; 
	private $created_date;
	private $pdo; 
	
	public function __construct() {
		$this->pdo = new \config\database();
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
