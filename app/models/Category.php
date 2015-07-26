<?php 

namespace app\models;

class Category {

	private $id;
	private $name;
	private $pdo; 
	
	public function __construct() {
		$this->pdo = new \config\database();
	}

	public function addCategory(array $data) {
		$query = $this->pdo->insert(
			'INSERT INTO category(name)
			VALUES (:name)', array(
				':name' => $data['name']
			)
		);

		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	public function getCategory($id) {
		$result = $this->pdo->query(
			'SELECT * FROM category
			WHERE id = :id', array(
				':id' => $id
			)
		);

		return $result;
	}

	public function editCategory(array $data) {
		$query = $this->pdo->update(
			'UPDATE category 
			SET name = :name
			WHERE id = :id', array(
				':name' => $data['name'],
				':id' => $data['id']
			)
		);

		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	public function deleteCategory($id) {
		$query = $this->pdo->delete('category', $id);

		if ($query) {
			return true;
		} else {
			return false;
		}
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
