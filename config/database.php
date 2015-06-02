<?php 

class database {

	const DSN = 'mysql:dbname=test;host=localhost';
	const DATABASE = 'test';
	const USER = 'root';
	const PASS = 'root';
	
	public $pdo;
	private $install;
	
	public function __construct() {
		$this->dbConnect(self::DSN,self::USER,self::PASS);
	}
	
	private function dbConnect($dsn, $user, $pass) {
		try {
		    $this->pdo = new PDO($dsn, $user, $pass);
		    $this->setInstall(false);
		} catch (PDOException $e) {
		    if($e->getCode() == 1049) {
				$this->setInstall(true);
		    }
		    echo 'Connexion échouée : ' . $e->getMessage();
		}
		return true;
	}
	
	public function getInstall() {
		return $this->install;
	}
	
	public function setInstall($install) {
		$this->install = $install;
		return $this;
	}
}
