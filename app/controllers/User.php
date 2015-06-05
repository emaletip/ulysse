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
}