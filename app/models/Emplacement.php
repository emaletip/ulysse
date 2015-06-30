<?php 

namespace app\models;

class Emplacement {

	private $id;
	private $name;
	private $nb_column;
	private $pdo; 
	
	public function __construct() {
		$this->pdo = new \config\database();
	}
	
	public function getPdo() {
		return $this->pdo;	
	}
	
	public function updateBlock($post) {
		$sql ='UPDATE emplacement SET ';
		foreach($post as $k => $v) {
			if($k != 'id'){
				$sqldatas[] = $k.'=:'.$k;
			}
			$datas[':'.$k] = $v;
		}
		$sql .= implode(', ', $sqldatas);
		$sql .= ' WHERE id=:id;';
		
		$dbuser = $this->getPdo()->update($sql, $datas);
		return $dbuser;
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
		$this->name= $name;
		return $this;
	}
	public function getNb_column() {
		return $this->nb_column;
	}
	public function setNb_column($nb_column) {
		$this->nb_column = $nb_column;
		return $this;
	}
}	
