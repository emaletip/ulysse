<?php 

namespace app\models;

class Content {

    private $pdo;
	private $id;
	private $created_date;
	private $content_type_name;
	private $created_user;
    
    public function getList(){
        $query = 'SELECT c.*, ft.*, fp.*, c.id AS content_id, t.*, t.id AS content_type_id FROM `content` c
        JOIN `content_type` t ON c.content_type_name = t.name
        JOIN `field_title` ft ON c.id = ft.content_id
        JOIN `field_price` fp ON c.id = fp.content_id
        WHERE c.`content_type_name` = \'product\'';
        $results = $this->pdo->query($query);
        return $results;
    }
    
    public function __construct() {
		$this->pdo = new \config\database();
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
	
	public function getCreated_date() {
		return $this->created_date;
	}
	
	public function setCreated_date($created_date) {
		$this->created_date = $created_date;
		return $this;
	}
	
	public function getContent_type_name() {
		return $this->content_type_name;
	}
	
	public function setContent_type_name($content_type_name) {
		$this->content_type_name = $content_type_name;
		return $this;
	}
	 
}	
