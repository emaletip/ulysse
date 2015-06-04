<?php 

namespace config;

class database {

	public $pdo;
	private $install;
	
	public function __construct() {
		global $ini_array;
		$this->dbConnect($ini_array['dsn'],$ini_array['user'],$ini_array['password']);
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
}
