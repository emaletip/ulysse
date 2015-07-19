<?php 

namespace app\controllers;

class User {

	private $userModel;

	public function __construct() {
		$this->userModel = new \app\models\User();
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

		$add = $this->userModel->addUser($_POST);

		if ($add === true) {
			$_SESSION['flash']['user']['key'] = 'success';
			$_SESSION['flash']['user']['msg'] = '<b>Félicitations ! </b> Vos données ont bien été enregistrées.';
			$_SESSION['flash']['user']['time'] = time() + 2;
		
			redirect('dashboard/user/list');
		} else {
			$_SESSION['flash']['user']['key'] = 'danger';

			foreach ($add as $v) {
				$_SESSION['flash']['user']['msg'] .= $v.'<br>';
			}

			$_SESSION['flash']['user']['time'] = time() + 2;
		
			redirect('dashboard/user/add');
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
}