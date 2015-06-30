<?php 

namespace app\models;

class Content {

    private $pdo;
	private $id;
	private $created_date;
	private $content_type_name;
	private $created_user;
    
    public function getFields($id) {
        //$content_type = $this->pdo->query('SELECT id, content_type_name FROM content WHERE id = '.$id.'');
    }
    
    public function getProductList(){
        $query = 'SELECT c.*, ft.*, fp.*, fs.*, fc.*, c.id AS content_id, t.*, t.id AS content_type_id FROM `content` c
        JOIN `content_type` t ON c.content_type_name = t.name
        JOIN `field_title` ft ON c.id = ft.content_id
        JOIN `field_price` fp ON c.id = fp.content_id
        JOIN `field_stock` fs ON c.id = fs.content_id
        JOIN `field_category` fc ON c.id = fc.content_id
        WHERE c.`content_type_name` = \'product\'';
        $results = $this->pdo->query($query);
        return $results;
    }
    
    public function getProduct($id){
        $query = 'SELECT c.*, ft.*, fp.*, fs.*, fc.*, c.id AS content_id, t.*, t.id AS content_type_id FROM `content` c
        JOIN `content_type` t ON c.content_type_name = t.name
        JOIN `field_title` ft ON c.id = ft.content_id
        JOIN `field_description` fd ON c.id = fd.content_id
        JOIN `field_price` fp ON c.id = fp.content_id
        JOIN `field_stock` fs ON c.id = fs.content_id
        JOIN `field_category` fc ON c.id = fc.content_id
        WHERE c.`content_type_name` = \'product\' AND c.id = '.$id.'';
        $results = $this->pdo->query($query);
        return $results;  
    }
    
    public function getCategory($id){
        $query = 'SELECT * FROM category WHERE id = '.$id.'';
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
