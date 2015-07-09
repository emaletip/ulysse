<?php 

namespace app\models;

class Category {

	private $id;
	private $name;
	private $pdo; 
	
	public function __construct() {
		$this->pdo = new \config\database();
	}
	
	public function getPdo() {
		return $this->pdo;	
	}
	
	public function getList() {
		return $this->pdo->query('SELECT * FROM category;');
	}
	
 	public function getId() {
		return $this->id;
	}
	
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	
 	public function getName() {
		return $this->name;
	}
	
	public function setName($name) {
		$this-> name = $name;
		return $this;
	}
	

}	
