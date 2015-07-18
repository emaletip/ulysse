<?php 

namespace app\controllers;

class Block {

	private $blockModel;
	private $contentModel;

	public function __construct() {
		$this->blockModel = new \app\models\Block();
		$this->contentModel = new \app\models\Content();
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

	public function getSlider_list() {
		return $this->contentModel->getSliderList();
	}

	public function getEdit($id) {
		return $this->blockModel->getBlock($id);
	}

	public function getSlider_edit($id) {
		return $this->contentModel->getSlider($id);
	}
	public function getView($id) {
		return $this->blockModel->getBlock($id);
	}
	
	public function getSlider_view() {
		return $this->contentModel->getSliderView();
	}
	
	public function getSlider_add() {
	}
	
	public function postSlider_add() {
		$dirimg = 'Slider';
		if(isset($_FILES) && $_FILES['path']['name'] != '') {
			if(isset($_POST['old_img'])) {
				$old_img = __DIR__.'/../../'.$_POST['old_img'];
				if(file_exists($old_img)) {
					unlink($old_img);
				}
				unset($_POST['old_img']);
			}
			$_POST['path'] = handleFile($_FILES['path'], $dirimg);
		} else {
			if(isset($_POST['old_img'])) {
				unset($_POST['old_img']);
			}
			$_POST['path'] ='';
		}
		$this->contentModel->addSlider($_POST);
		
		
		$_SESSION['flash']['user']['key'] = 'success';
		$_SESSION['flash']['user']['msg'] = '<b>Félicitations ! </b> Vos données ont bien été enregistrées.';
		$_SESSION['flash']['user']['time'] = time() + 1;
	
		redirect('dashboard/slider');

	}
	
	public function postSlider_update() {
		$dirimg = 'Slider';
		if(isset($_FILES['content_path']) && $_FILES['content_path']['name'] != '') {
			if(isset($_POST['old_img'])) {
				$old_img = __DIR__.'/../../'.$_POST['old_img'];
				if(file_exists($old_img)) {
					unlink($old_img);
				}
				unset($_POST['old_img']);
			}
			$_POST['content_path'] = handleFile($_FILES['content_path'], $dirimg);
		} else {
			if(isset($_POST['old_img'])) {
				unset($_POST['old_img']);
			}
			unset($_POST['content_path']);
		}

		$this->contentModel->updateSlider($_POST);		
		
		$_SESSION['flash']['user']['key'] = 'success';
		$_SESSION['flash']['user']['msg'] = '<b>Félicitations ! </b> Vos données ont bien été enregistrées.';
		$_SESSION['flash']['user']['time'] = time() + 1;
	
		redirect('dashboard/slider');

	}
	public function	getSlider_delete($id) {
		$this->contentModel->deleteSlider($id);
		
		$_SESSION['flash']['user']['key'] = 'success';
		$_SESSION['flash']['user']['msg'] = '<b>Félicitations ! </b> Vos données ont bien été supprimées.';
		$_SESSION['flash']['user']['time'] = time() + 1;
	
		redirect('dashboard/slider');

	}
	
	public function postSlider_edit() {
		$dirimg = 'Slider';
		if(isset($_FILES) && $_FILES['path']['name'] != '') {
			if(isset($_POST['old_img'])) {
				$old_img = __DIR__.'/../../'.$_POST['old_img'];
				if(file_exists($old_img)) {
					unlink($old_img);
				}
				unset($_POST['old_img']);
			}
			$_POST['path'] = handleFile($_FILES['path'], $dirimg);
		} else {
			if(isset($_POST['old_img'])) {
				unset($_POST['old_img']);
			}
			$_POST['path'] ='';
		}

		$this->blockModel->updateSlider($_POST);
		
		if(!strstr($_SERVER['HTTP_REFERER'], 'emplacement')) {		
			$_SESSION['flash']['config']['key'] = 'success';
			$_SESSION['flash']['config']['msg'] = '<b>Félicitations ! </b> Vos données ont bien été enregistrées.';
			$_SESSION['flash']['config']['time'] = time() + 1;				
		}

		redirect('dashboard/slider/'.($_POST['id'] ? $_POST['id'] : ''));
	}
	
	public function postEdit() {
		if(!isset($_POST['is_active'])) {
			$_POST['is_active'] = 0;
		}

		$this->blockModel->updateBlock($_POST);
		
		if(!strstr($_SERVER['HTTP_REFERER'], 'emplacement')) {		
			$_SESSION['flash']['config']['key'] = 'success';
			$_SESSION['flash']['config']['msg'] = '<b>Félicitations ! </b> Vos données ont bien été enregistrées.';
			$_SESSION['flash']['config']['time'] = time() + 1;				
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
