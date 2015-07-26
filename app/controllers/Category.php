<?php 

namespace app\controllers;

class Category {

	public $categoryModel;

	public function __construct() {
		$this->categoryModel = new \app\models\Category();
		return $this;
	}

	public function getCategory($id) {
		return $this->categoryModel->getCategory($id);
	}

	public function getCategory_list() {
		return $this->categoryModel->getList();
	}

	public function getCategory_add() {
	}

	public function postCategory_add() {
		$r = $this->categoryModel->addCategory($_POST);

		if($r) {
			$_SESSION['flash']['user']['key'] = 'success';
			$_SESSION['flash']['user']['msg'] = '<b>Félicitation ! </b> Votre catégorie a bien été enregistrée.';
			$_SESSION['flash']['user']['time'] = time() + 1;

			redirect('dashboard/category');
		} else {
			$_SESSION['flash']['user']['key'] = 'error';
			$_SESSION['flash']['user']['msg'] = '<b>Attention ! </b> Votre catégorie n\'a pas été enregistrée.';
			$_SESSION['flash']['user']['time'] = time() + 1;
		}
	}

	public function getCategory_edit($id) {
		return $this->categoryModel->getCategory($id);
	}

	public function postCategory_edit() {
		$r = $this->categoryModel->editCategory($_POST);

		if($r) {
			$_SESSION['flash']['user']['key'] = 'success';
			$_SESSION['flash']['user']['msg'] = '<b>Félicitation ! </b> Votre catégorie a bien été modifiée.';
			$_SESSION['flash']['user']['time'] = time() + 1;

			redirect('dashboard/category');
		} else {
			$_SESSION['flash']['user']['key'] = 'error';
			$_SESSION['flash']['user']['msg'] = '<b>Attention ! </b> Votre catégorie n\'a pas été modifiée.';
			$_SESSION['flash']['user']['time'] = time() + 1;
		}
	}

	public function getCategory_delete($id) {
		$r = $this->categoryModel->deleteCategory($id);

		if($r) {
			$_SESSION['flash']['user']['key'] = 'success';
			$_SESSION['flash']['user']['msg'] = '<b>Félicitation ! </b> Votre catégorie a bien été supprimée.';
			$_SESSION['flash']['user']['time'] = time() + 1;

			redirect('dashboard/category');
		} else {
			$_SESSION['flash']['user']['key'] = 'error';
			$_SESSION['flash']['user']['msg'] = '<b>Attention ! </b> Votre catégorie n\'a pas été supprimée.';
			$_SESSION['flash']['user']['time'] = time() + 1;
		}
	}

}	
