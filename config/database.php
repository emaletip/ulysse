<?php 

namespace config;

class database {

	public $pdo;
	private $install;
	
	public function __construct() {
		global $ini_array;
		$this->dbConnect($ini_array['dsn'],$ini_array['user'],$ini_array['password']);
		return $this;
	}
	
	private function dbConnect($dsn, $user, $pass) {
		try {
		    $this->pdo = new \PDO($dsn, $user, $pass);
		    $this->setInstall(false);
		} catch (PDOException $e) {
		    if($e->getCode() == 1049) {
				$this->setInstall(true);
		    }
		    echo 'Connexion échouée : ' . $e->getMessage();
		}
		return true;
	}
	
	public function getCmsConfig() {
		$configcms = $this->pdo->query('SELECT * FROM config', \PDO::FETCH_OBJ);
		return $configcms->fetch();
		
	}
		
	public function getInstall() {
		return $this->install;
	}
	
	public function setInstall($install) {
		$this->install = $install;
		return $this;
	}
		
    public function query($string, $datas = array())
    {   
    	if (empty($datas)) {    	
			$req = $this->pdo->query($string);
			if ($req) {	
			$result = $req->fetchAll(\PDO::FETCH_OBJ);
			} else {
				$result = array();
			}
    	} else {
    		$req = $this->pdo->prepare($string);
			foreach($datas as $k => $v) {
	        	$req->bindValue($k, $v);
	        }          
	        $req->execute();
			$result = $req->fetchAll(\PDO::FETCH_OBJ);
    	}
        return($result);
    }
    
    public function update($string, $datas = array())
    {
        $req = $this->pdo->prepare($string);
        if (!empty($datas)) {
	        foreach($datas as $k => $v) {
	        	$req->bindValue($k, $v);
	        }
        }           		
        $result = $req->execute();
		
        return($result);
    }
    
    public function insert($string, $datas = array())
    {
        $req = $this->pdo->prepare($string);
		if (!empty($datas)) {
	        foreach($datas as $k => $v) {
	        	$req->bindValue($k, $v);
	        }
        }           		
        $result = $req->execute();
        return($result);
    }
    
    public function delete($table, $id)
    {
        $req = $this->pdo->prepare('SELECT * FROM '.$table.' WHERE id='.$id);          		
        $result = $req->execute();
        return($result);
    }
    
    public function lastId()
    {
        return $this->pdo->lastInsertId();
    }
	
	
}
