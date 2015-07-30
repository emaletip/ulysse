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
	
	public function getCustomCms() {
        return @file_get_contents('public/css/custom-ape.css');
	}
	
	public function postCustomCms() {
		$customcsss = $_POST['custom'];
		$ini = "public/css/custom-ape.css";

        $r = @file_put_contents($ini, $customcsss);

		redirect('dashboard/config/custom');
	}

	public function postConfig_update() {
		$dirimg = 'Config';
				
		if(isset($_FILES) && $_FILES['logo']['name'] != '') {
			if(isset($_POST['old_img'])) {
				$old_img = __DIR__.'/../../'.$_POST['old_img'];
				if(file_exists($old_img)) {
					unlink($old_img);
				}
				unset($_POST['old_img']);
			}
			$_POST['logo'] = handleFile($_FILES['logo'], $dirimg);
		} else {
			if(isset($_POST['old_img'])) {
				unset($_POST['old_img']);
			}
			unset($_POST['logo']);
		}
	
		$this->configModel->updateConfig($_POST);

		$_SESSION['flash']['config']['key'] = 'success';
		$_SESSION['flash']['config']['msg'] = '<b>Félicitations ! </b> Vos données ont bien été enregistrées.';
		$_SESSION['flash']['config']['time'] = time() + 1;
	
		redirect('dashboard/config');
	}
	
}	
