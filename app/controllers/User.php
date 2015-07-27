<?php 

namespace app\controllers;

class User {

	private $userModel;
	private $userCart;
	public $orderModel;
	public $contentModel;

	public function __construct() {
	
		if(!isset($_SESSION['user']) && is_url_user() && !is_url_home() ){
			redirect('index');
		}
	
		$this->userModel = new \app\models\User();
		$this->userCart = new \app\controllers\Cart();
		$this->orderModel = new \app\models\Order();
		$this->contentModel = new \app\models\Content();
		return $this->userModel;
	}

	public function postConnect() {
		
		if(isset($_SESSION['user'])) {
			unset($_SESSION['user']);
		}
		
		$username = $_POST['user']['email'];
		$password = $_POST['user']['password'];
		$user = $this->userModel->connectUser($username, $password);

		if($user) {
			$_SESSION['user'] = $user;
			setcookie('userinfo', json_encode($user), (time() + 3600));
			return true;
		} else {
			show_flash(false,false,'<b>Erreur ! </b> Vous avez indiqué un mauvais email et/ou mot de passe.',false,false);
			return false;
		}
	}
	
	public function postConnectFront() {
		
		if(isset($_SESSION['user'])) {
			unset($_SESSION['user']);
		}
		
		$username = $_POST['user']['email'];
		$password = $_POST['user']['password'];
		$user = $this->userModel->connectUser($username, $password);
		if($user) {
			$_SESSION['user'] = $user;
			if (isset($_POST['user']['remember']) && $_POST['user']['remember'] == 1) {
				setcookie('user',json_encode($user), (time() + 3600));
				setcookie('userloged',1, (time() + 3600));
			}
			
			/* set new cart or get old one */
			if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
				$this->userCart->initCart($user->id);
			}
			
			return true;
		} else {
			return false;
		}
	}

	public function getUser_list() {
		$users = $this->userModel->listUser();
		return $users;
	}

	public function getUser($id) {
		$user = $this->userModel->getUser($id);
		return $user;
	}

	public function getUser_add() {
	}
	
	public function postUser_add() {
		unset($_POST['submit']);

		if(!isset($_POST['login'])) {
			$_POST['login'] = '';
			$_POST['address1'] = '';
			$_POST['address2'] = '';
			$_POST['postal_code'] = '';
			$_POST['city'] = '';
			$_POST['country'] = '';
		} 
		
		$add = $this->userModel->addUser($_POST);

		if ($add === true) {
			$_SESSION['flash']['user']['key'] = 'success';
			$_SESSION['flash']['user']['msg'] = '<b>Félicitations ! </b> Vos données ont bien été enregistrées.';
			$_SESSION['flash']['user']['time'] = time() + 1;
		
			redirect('dashboard/user/list');
		} else {
			$_SESSION['flash']['user']['key'] = 'danger';
			foreach ($add as $v) {
				$_SESSION['flash']['user']['msg'] .= $v.'<br>';
			}
			$_SESSION['flash']['user']['time'] = time() + 1;
		
			redirect('dashboard/user/add');
		}
	}

	public function getUser_edit($id) {
		$user = $this->userModel->getUser($id);

		if($_SESSION['user']->role_id != 1 && $user[0]->role_id == 1) {
			$_SESSION['flash']['user']['key'] = 'warning';
			$_SESSION['flash']['user']['msg'] = '<b>Attention ! </b> Vous n\'êtes pas autorisé à modifier le Superadmin.';
			$_SESSION['flash']['user']['time'] = time() + 1;
		
			redirect('dashboard/user/list');
		} else {
			return $user;
		}
	}

	public function postUser_update() {
		$dirimg = "User";
		if(isset($_FILES) && $_FILES['avatar']['name'] != '') {
			if(isset($_POST['old_avt'])) {
				$old_avt = __DIR__.'/../../'.$_POST['old_avt'];
				if(file_exists($old_avt)) {
					unlink($old_avt);
				}
				unset($_POST['old_avt']);
			}
			$_POST['avatar'] = handleFile($_FILES['avatar'], $dirimg);
		} else {
			if(isset($_POST['old_avt'])) {
				unset($_POST['old_avt']);
			}
			unset($_POST['avatar']);
		}

		$this->userModel->updateUser($_POST);

		$_SESSION['flash']['user']['key'] = 'success';
		$_SESSION['flash']['user']['msg'] = '<b>Félicitations ! </b> Vos données ont bien été enregistrées.';
		$_SESSION['flash']['user']['time'] = time() + 1;
	
		redirect('dashboard/user/'.$_POST['id']);
	}

	public function getUser_delete($id) {
		$this->userModel->deleteUser($id);

		$_SESSION['flash']['user']['key'] = 'success';
		$_SESSION['flash']['user']['msg'] = '<b>Félicitations ! </b> Votre utilisateur a bien été supprimé.';
		$_SESSION['flash']['user']['time'] = time() + 1;

		redirect('dashboard/user/list');
	}

	public function getUser_front_edit($id) {
		$user = $this->userModel->getUser($id);

		if($_SESSION['user']->role_id != $user[0]->id) {
			$_SESSION['flash']['user']['key'] = 'warning';
			$_SESSION['flash']['user']['msg'] = '<b>Attention ! </b> Vous n\'êtes pas autorisé à accéder à cette page.';
			$_SESSION['flash']['user']['time'] = time() + 1;

			redirect('user/' . $_SESSION['user']->id);
		} else {
			return $user;
		}
	}

	public function postUser_front_update() {
		$dirimg = "User";
		if(isset($_FILES) && $_FILES['avatar']['name'] != '') {
			if(isset($_POST['old_avt'])) {
				$old_avt = __DIR__.'/../../'.$_POST['old_avt'];
				if(file_exists($old_avt)) {
					unlink($old_avt);
				}
				unset($_POST['old_avt']);
			}
			$_POST['avatar'] = handleFile($_FILES['avatar'], $dirimg);
		} else {
			if(isset($_POST['old_avt'])) {
				unset($_POST['old_avt']);
			}
			unset($_POST['avatar']);
		}

		$this->userModel->updateUser($_POST);

		$_SESSION['flash']['user']['key'] = 'success';
		$_SESSION['flash']['user']['msg'] = '<b>Félicitations ! </b> Vos données ont bien été enregistrées.';
		$_SESSION['flash']['user']['time'] = time() + 1;
	
		redirect('user/'.$_POST['id']);
	}
}