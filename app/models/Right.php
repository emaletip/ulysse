<?php 

namespace app\models;

class Right {

	private $id;
 
 	public function getId() {
		return $this->id;
	}
	
	public function setId($id) {
		$this->id = $id;
		return $this;
	}

}	
