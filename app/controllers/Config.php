<?php 

namespace app\controllers;

class Config {

	private $configModel;

	public function __construct() {
		$this->configModel = new \app\models\Config();
		return $this;
	}

	public function getConfig() {
		return $this->configModel->getConfig();
	}

	public function postConfig_update() {
		
/*
		$file = handleFile($_FILES['logo'], 'public/img/Config');
		var_dump($file);
		die;
*/
		$this->configModel->updateConfig($_POST);
		
		$_SESSION['flash']['config']['key'] = 'success';
		$_SESSION['flash']['config']['msg'] = '<b>Félicitations ! </b> Vos données ont bien été enregistrées.';
		$_SESSION['flash']['config']['time'] = time() + 2;
	
		redirect('dashboard/config');
	}
	
}	
