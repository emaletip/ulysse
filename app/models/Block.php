<?php 

namespace app\models;

class Block {

	private $id;
	private $name;
	private $is_active;
	private $is_editable;
	private $content_block;
 
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
}	
