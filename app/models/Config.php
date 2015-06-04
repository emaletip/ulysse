<?php 

namespace app\models;

class Config {

	private $id;
	private $sitename;
	private $slogan;
	private $logo;
	private $copyright;
	private $is_maintenance;
	private $created_date;
	private $updated_date;
	
	public function __construct() {
		$db = new \config\database();
		$configdb = $db->pdo->query('SELECT * FROM config');
		foreach( $configdb->fetch(\PDO::FETCH_OBJ) as $k => $v) {
			$key = 'set'.ucfirst($k);
			$this->$key($v);
		}
	}
	
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	
	public function set_id($value){
	    $this->id = $value;
	}
	
	public function setSitename($value){
	    $this->sitename = $value;
	}
	
	public function setSlogan($value){
	    $this->slogan = $value;
	}
	
	public function setLogo($value){
	    $this->logo = $value;
	}
	
	public function setCopyright($value){
	    $this->copyright = $value;
	}
	
	public function setIs_maintenance($value){
	    $this->is_maintenance = $value;
	}
	
	public function setCreated_date($value){
	    $this->created_date = $value;
	}
	
	public function setUpdated_date($value){
	    $this->updated_date = $value;
	}
	
	public function getId(){
	    return $this->id;
	}
	
	public function getSitename(){
	    return $this->sitename;
	}
	
	public function getSlogan(){
	    return $this->slogan;
	}
	
	public function getLogo(){
	    return $this->logo;
	}
	
	public function getCopyright(){
	    return $this->copyright;
	}
	
	public function getIs_maintenance(){
	    return $this->is_maintenance;
	}
	
	public function getCreated_date(){
	    return $this->created_date;
	}
	
	public function getUpdated_date(){
	    return $this->updated_date;
	}

	
}	
