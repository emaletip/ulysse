<?php 

namespace app\models;

class Order {

	private $id;
 
 	public function getId() {
		return $this->id;
	}
	
	public function setId($id) {
		$this->id = $id;
		return $this;
	}

}	
