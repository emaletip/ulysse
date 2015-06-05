<?php 

namespace app\controllers;

class Config {

	private $config;

	public function __construct() {
		$this->config = new \app\models\Config();
	}

	public function getConfig() {
		return $this->config->getConfig();
	}

	public function postConfig_update() {
		
		$this->config->updateConfig($_POST);
		
		$_SESSION['flash']['config']['key'] = 'success';
		$_SESSION['flash']['config']['msg'] = '<b>Félicitations ! </b> Vos données ont bien été enregistrées.';
		$_SESSION['flash']['config']['time'] = time() + 2;
	
		redirect('dashboard/config');
	}
	
}	
