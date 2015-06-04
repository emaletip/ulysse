<?php 

namespace app\models;

class Emplacement {

	private $id;
 
 	public function getId() {
		return $this->id;
	}
	
	public function setId($id) {
		$this->id = $id;
		return $this;
	}

}	
