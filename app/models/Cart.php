<?php

namespace app\models;

class Cart {

	private $id;
	private $product_id;
	private $user_id;
	private $quantity;
	private $pdo; 
	
	public function __construct() {
		$this->pdo = new \config\database();
	}
	
	public function deleteProduct($id) {
		$res = $this->pdo->delete('cart',$id);
	}
	
	public function deleteCart($user_id) {		
		$query = $this->pdo->update(
        'DELETE FROM cart WHERE user_id = :user_id', array(
            ':user_id' => $user_id
            )
        );
        return $query;
	} 
	
	public function getUserContent($id) {
		return $this->pdo->query('SELECT * FROM user_content 
								 WHERE id=:id',
								 array(':id' => $id));
		
	}
	
	public function addProduct($id, $id_content) {
		
		$cart_product = $this->pdo->query('SELECT * FROM cart 
								 WHERE product_id=:product_id 
								 AND user_id=:user_id
								 AND user_content_id=:user_content_id',
								 array(':product_id' => $id,
								 	   ':user_id' => $_SESSION['user']->id,
								 	   ':user_content_id' => $id_content
								 ));	

		if(empty($cart_product)){
			/* Insert product in cart*/			
			$res = $this->pdo->insert(
	        'INSERT INTO cart (user_id, product_id, quantity, user_content_id)
	        VALUES (:user_id, :product_id, :quantity, :user_content_id)', array(
	            ':product_id' => $id,
	            ':user_id' => $_SESSION['user']->id,
	            ':user_content_id' => $id_content,
	            ':quantity' => 1
	            )
	        );  
        } else {
        	$cart_product = current($cart_product);
        	$quantity = $cart_product->quantity + 1;

			/* Update quantity */
			$res = $this->pdo->insert('UPDATE cart SET quantity=:quantity WHERE id=:id',
									  array(':id'=>$cart_product->id,':quantity'=>$quantity));		
        }

        return $res;      
	}
	
	public function listCart() {
		if(!isset($_SESSION['user'])) {
			$products = array();
		} else {
			$products = $this->pdo->query(
			'SELECT * FROM cart WHERE user_id=:user_id',
			array(':user_id' => $_SESSION['user']->id)
			);	
		}
		
		return $products;
	}
	
	
}