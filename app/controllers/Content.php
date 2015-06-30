<?php 

namespace app\controllers;

class Content {
    
    public $contentModel;
    
    public function postProduct_add() {
		unset($_POST['submit']);

		$add = $this->contentModel->addProduct($_POST);

		$_SESSION['flash']['user']['key'] = 'success';
		$_SESSION['flash']['user']['msg'] = '<b>Félicitations ! </b> Vos données ont bien été enregistrées.';
		$_SESSION['flash']['user']['time'] = time() + 2;
	
		redirect('dashboard/content');
	}
    
    public function getProduct_add() {
	}
    
    public function postProduct_edit() {
		unset($_POST['submit']);

		$edit = $this->contentModel->editProduct($_POST);

		$_SESSION['flash']['user']['key'] = 'success';
		$_SESSION['flash']['user']['msg'] = '<b>Félicitations ! </b> Vos données ont bien été enregistrées.';
		$_SESSION['flash']['user']['time'] = time() + 2;
	
		redirect('dashboard/content');
	}
    
    public function getProduct_edit($id) {
        return $this->contentModel->getProduct($id);
	}
    
    public function postProduct_delete() {
		unset($_POST['submit']);

		$edit = $this->contentModel->deleteProduct($_POST);

		$_SESSION['flash']['user']['key'] = 'success';
		$_SESSION['flash']['user']['msg'] = '<b>Félicitations ! </b> Vos données ont bien été supprimées.';
		$_SESSION['flash']['user']['time'] = time() + 2;
	
		redirect('dashboard/content');
	}
    
    public function getProduct_delete($id) {
        return $this->contentModel->getProduct($id);
	}

	public function __construct() {
		$this->contentModel = new \app\models\Content();
		return $this;
	}

	public function getProduct($id) {
		return $this->contentModel->getProduct($id);
	}

	public function getProductList() {
        return $this->contentModel->getProductList();
    }
}	
