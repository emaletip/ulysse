<?php 

namespace app\controllers;

class Config {

	public function getConfig() {
		return new \app\models\Config();
	}

}	
