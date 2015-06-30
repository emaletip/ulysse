<?php 

namespace app\models;

class Block {

	private $id;
	private $name;
	private $title;
	private $is_active;
	private $is_editable;
	private $content_block;
	private $emplacement_id;
	private $position;
	private $pdo; 
	
	public function __construct() {
		$this->pdo = new \config\database();
	}
	
	public function getblock($id) {
		$block = $this->pdo->query('SELECT * FROM block WHERE id=:id;', array(':id' => $id));
		foreach( current($block) as $k => $v) {
			$key = 'set'.ucfirst($k);
			$this->$key($v);
		}
		return $this;
	}

	public function updateBlock($post) {
		$sql ='UPDATE block SET ';
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
	
	public function getList() {
		return $this->pdo->query('SELECT * FROM block;');
	}
		
	public function getEmplacements() {
		return $this->pdo->query('SELECT block.*, emplacement.name as emplacement_name, emplacement.id as emplacement_id, emplacement.nb_column as nb_column FROM block INNER JOIN emplacement ON emplacement.id=block.emplacement_id ORDER BY block.position');
	}	
	
	public function getList_emplacements() {
		return $this->pdo->query('SELECT * FROM emplacement');
	}	
	
	public function getPdo() {
		return $this->pdo;	
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
		$this->name = $name;
		return $this;
	}
	
	public function getTitle() {
		return $this->title;
	}
	
	public function setTitle($title) {
		$this->title = $title;
		return $this;
	}
	
	public function getIs_active() {
		return $this->is_active;
	}
	
	public function setIs_active($is_active) {
		$this->is_active = $is_active;
		return $this;
	}
	
	public function getIs_editable() {
		return $this->is_editable;
	}
	
	public function setIs_editable($is_editable) {
		$this->is_editable = $is_editable;
		return $this;
	}
	
	public function getContent_block() {
		return $this->content_block;
	}
	
	public function setContent_block($content_block) {
		$this->content_block = $content_block;
		return $this;
	}
	
	public function getEmplacement_id() {
		return $this->emplacement_id;
	}
	
	public function setEmplacement_id($emplacement_id) {
		$this->emplacement_id = $emplacement_id;
		return $this;
	}
	
	public function getPosition() {
		return $this->position;
	}
	
	public function setPosition($position) {
		$this->position = $position;
		return $this;
	}
}	
