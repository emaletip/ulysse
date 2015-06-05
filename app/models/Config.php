<?php 

namespace app\models;

class Config {

	private $pdo; 
	private $id;
	private $sitename;
	private $slogan;
	private $logo;
	private $copyright;
	private $is_maintenance;
	private $created_date;
	private $updated_date;
	
	public function __construct() {
		$this->pdo = new \config\database();
	}
	
	public function getPdo() {
		return $this->pdo;	
	}
	
	public function updateConfig($post) {
		$sql ='UPDATE config SET ';
		foreach($post as $k => $v) {
			$sqldatas[] = $k.'=:'.$k;
			$datas[':'.$k] = $v;
		}
		$sql .= implode(', ',$sqldatas);
		$sql .= ' WHERE id=:id';
		$dbuser = $this->getPdo()->update($sql, $datas);
	}
	
	public function getConfig() {
		$configdb = $this->pdo->query('SELECT * FROM config');
		foreach( current($configdb) as $k => $v) {
			$key = 'set'.ucfirst($k);
			$this->$key($v);
		}
		return $this;
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
