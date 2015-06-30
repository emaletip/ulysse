<?php 

namespace app\controllers;

class Block {

	private $blockModel;

	public function __construct() {
		$this->blockModel = new \app\models\Block();
		return $this;
	}
/*
	
	public function displayBlock($name) {
		
		$block = $this->blockModel->getBlock_by_name($name);
		
		switch ($name) {
		case 'block_informations':
			$html = '';
			
			break;
		}
	}
	
*/
	public function getList() {
		return $this->blockModel->getList();
	}

	public function getEdit($id) {
		return $this->blockModel->getBlock($id);
	}

	public function getView($id) {
		return $this->blockModel->getBlock($id);
	}
		
	public function postEdit() {
		if(!isset($_POST['is_active'])) {
			$_POST['is_active'] = 0;
		}

		$this->blockModel->updateBlock($_POST);
		
		if(!strstr($_SERVER['HTTP_REFERER'], 'emplacement')) {		
			$_SESSION['flash']['config']['key'] = 'success';
			$_SESSION['flash']['config']['msg'] = '<b>Félicitations ! </b> Vos données ont bien été enregistrées.';
			$_SESSION['flash']['config']['time'] = time() + 2;				
		}

		redirect('dashboard/block/'.($_POST['id'] ? $_POST['id'] : ''));
	}

	public function getEmplacement() {
		return $this->blockModel->getEmplacements();
	}
	
	public function listEmplacement() {
		return $this->blockModel->getList_emplacements();
	}
	

}	
