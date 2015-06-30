<?php 

namespace app\controllers;

class Emplacement {

	private $emplacementModel;

	public function __construct() {
		$this->emplacementModel = new \app\models\Emplacement();
		return $this;
	}

	public function postUpdate() {
		$this->emplacementModel->updateBlock($_POST);		
		redirect('dashboard/block');
	}

}	
