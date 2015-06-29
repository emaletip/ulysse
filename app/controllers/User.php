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

		$test = $this->userModel->addUser($_POST);

		$_SESSION['flash']['user']['key'] = 'success';
		$_SESSION['flash']['user']['msg'] = '<b>Félicitations ! </b> Vos données ont bien été enregistrées.';
		$_SESSION['flash']['user']['time'] = time() + 2;
	
		redirect('dashboard/user/list');
	}

	public function postUser_update() {
		$this->userModel->updateUser($_POST);

		$_SESSION['flash']['user']['key'] = 'success';
		$_SESSION['flash']['user']['msg'] = '<b>Félicitations ! </b> Vos données ont bien été enregistrées.';
		$_SESSION['flash']['user']['time'] = time() + 2;
	
		redirect('dashboard/user/'.$_POST['id']);
	}

	public function getUser_delete($id) {
		$this->userModel->deleteUser($id);

		$_SESSION['flash']['user']['key'] = 'success';
		$_SESSION['flash']['user']['msg'] = '<b>Félicitations ! </b> Votre utilisateur a bien été supprimé.';
		$_SESSION['flash']['user']['time'] = time() + 2;

		redirect('dashboard/user/list');
	}
}