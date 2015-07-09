<?php 

namespace app\controllers;

class Menu {

	public $menuModel;

	public function __construct() {
		$this->menuModel = new \app\models\Menu();
		return $this;
	}

	public function getList() {
		return $this->menuModel->getList();
	}
	
	public function postType() {
		return $this->menuModel->getItem_by_type($_POST['type']);
	}
	
	public function getAdd() {
	}	

	public function getDelete($id) {
		$this->menuModel->getPdo()->delete('content_menu', 	$id);
		redirect('dashboard/menu');
	}
	
	public function postAdd() {
		$this->menuModel->getAdd_item($_POST);
		redirect('dashboard/menu');
	}	

	public function postUpdate() {
			$this->menuModel->getUpdate_item($_POST);

		redirect('dashboard/menu');
	}	
	
	

}	
