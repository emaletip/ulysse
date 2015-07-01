<?php 

namespace app\models;

class Menu {

	private $id;
	private $content_id;
	private $label;
	private $pdo; 
	
	public function __construct() {
		$this->pdo = new \config\database();
	}
	
	public function getPdo() {
		return $this->pdo;	
	}
	
	public function getList() {
		return $this->pdo->query('SELECT * FROM menu;');
	}
	
 	public function getId() {
		return $this->id;
	}
	
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	
 	public function getContent_id() {
		return $this->content_id;
	}
	
	public function setContent_id($content_id) {
		$this->content_id = $content_id;
		return $this;
	}
	
 	public function getLabel() {
		return $this->label;
	}
	
	public function setLabel($label) {
		$this->label = $label;
		return $this;
	}

}	
