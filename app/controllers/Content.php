<?php 

namespace app\controllers;

class Content {
    
    public $contentModel;

    public function __construct() {
		$this->contentModel = new \app\models\Content();
		return $this;
	}
    
    public function postProduct_add() {
		unset($_POST['submit']);
		
		$add = $this->contentModel->addContent($_POST);

		$_SESSION['flash']['user']['key'] = 'success';
		$_SESSION['flash']['user']['msg'] = '<b>Félicitations ! </b> Vos données ont bien été enregistrées.';
		$_SESSION['flash']['user']['time'] = time() + 2;
	
		redirect('dashboard/product');
	}
    
    public function postPage_add() {
		unset($_POST['submit']);
		
		$add = $this->contentModel->addContent($_POST, 'page');

		$_SESSION['flash']['user']['key'] = 'success';
		$_SESSION['flash']['user']['msg'] = '<b>Félicitations ! </b> Vos données ont bien été enregistrées.';
		$_SESSION['flash']['user']['time'] = time() + 2;
	
		redirect('dashboard/page');
	}

    
    public function getProduct_add() {
	}

    public function getPage_add() {
	}	
	
    
    public function postProduct_edit() {
		unset($_POST['submit']);

		$edit = $this->contentModel->editContent($_POST);

		$_SESSION['flash']['user']['key'] = 'success';
		$_SESSION['flash']['user']['msg'] = '<b>Félicitations ! </b> Vos données ont bien été enregistrées.';
		$_SESSION['flash']['user']['time'] = time() + 2;
	
		redirect('dashboard/product/'.$_POST['content_id']);
	}
       
    public function postPage_edit() {
		$edit = $this->contentModel->editContent($_POST);
		

		$_SESSION['flash']['user']['key'] = 'success';
		$_SESSION['flash']['user']['msg'] = '<b>Félicitations ! </b> Vos données ont bien été enregistrées.';
		$_SESSION['flash']['user']['time'] = time() + 2;
	
		redirect('dashboard/page/'.$_POST['content_id']);
	}

    public function getProduct_edit($id) {
        return $this->contentModel->getProduct($id);
	}

    public function getPage_edit($id) {
        return $this->contentModel->getPage($id);
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

	public function getProduct($id) {
		return $this->contentModel->getProduct($id);
	}

	public function getPage($id) {
		return $this->contentModel->getPage($id);
	}
	
	public function getProductList() {
        return $this->contentModel->getProductList();
    }

    /*		ARTICLES 	*/

    public function postArticle_add() {
		unset($_POST['submit']);

		$dirimg = "Article";
		if(isset($_FILES) && $_FILES['image']['name'] != '') {
			if(isset($_POST['old_img'])) {
				$old_img = __DIR__.'/../../'.$_POST['old_img'];
				if(file_exists($old_img)) {
					unlink($old_img);
				}
				unset($_POST['old_img']);
			}
			$_POST['image'] = handleFile($_FILES['image'], $dirimg);
		} else {
			if(isset($_POST['old_img'])) {
				unset($_POST['old_img']);
			}
			unset($_POST['image']);
		}

		$add = $this->contentModel->addContent($_POST, 'article');

		$_SESSION['flash']['user']['key'] = 'success';
		$_SESSION['flash']['user']['msg'] = '<b>Félicitations ! </b> Vos données ont bien été enregistrées.';
		$_SESSION['flash']['user']['time'] = time() + 2;
	
		redirect('dashboard/article');
	}
    
    public function getArticle_add() {
	}
    
    public function postArticle_edit() {
		unset($_POST['submit']);

		$dirimg = "Article";
		if(isset($_FILES) && $_FILES['image']['name'] != '') {
			if(isset($_POST['old_img'])) {
				$old_img = __DIR__.'/../../'.$_POST['old_img'];
				if(file_exists($old_img)) {
					unlink($old_img);
				}
				unset($_POST['old_img']);
			}
			$_POST['image'] = handleFile($_FILES['image'], $dirimg);
		} else {
			if(isset($_POST['old_img'])) {
				unset($_POST['old_img']);
			}
			unset($_POST['image']);
		}

		$edit = $this->contentModel->editArticle($_POST);

		$_SESSION['flash']['user']['key'] = 'success';
		$_SESSION['flash']['user']['msg'] = '<b>Félicitations ! </b> Vos données ont bien été enregistrées.';
		$_SESSION['flash']['user']['time'] = time() + 2;
	
		redirect('dashboard/article/'.$_POST["id"]);
	}
    
    public function getArticle_edit($id) {
        return $this->contentModel->getArticle($id);
	}
    
    /*public function postArticle_delete() {
		unset($_POST['submit']);

		$edit = $this->contentModel->deleteArticle($_POST);

		$_SESSION['flash']['user']['key'] = 'success';
		$_SESSION['flash']['user']['msg'] = '<b>Félicitations ! </b> Vos données ont bien été supprimées.';
		$_SESSION['flash']['user']['time'] = time() + 2;
	
		redirect('dashboard/article');
	}*/
    
    public function getArticle_delete($id) {
    	$this->contentModel->deleteArticle($id);

    	$_SESSION['flash']['user']['key'] = 'success';
		$_SESSION['flash']['user']['msg'] = '<b>Félicitations ! </b> Votre utilisateur a bien été supprimé.';
		$_SESSION['flash']['user']['time'] = time() + 2;

		redirect('dashboard/article');
	}

	public function getArticle($id) {
		return $this->contentModel->getArticle($id);
	}

	public function getArticleList() {
        return $this->contentModel->getArticleList();
    }

    /*		FIN ARTICLES 	*/
    
	public function getPageList() {
        return $this->contentModel->getPageList();
    }    
}	
