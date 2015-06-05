<?php 

namespace app\controllers;

class User {

	public function postConnect() {
		if(isset($_SESSION['user'])) {
			unset($_SESSION['user']);
		}
		
		$username = $_POST['user']['email'];
		$password = $_POST['user']['password'];
		$userModel = new \app\models\User();
		$user = $userModel->connectUser($username, $password);
		if($user) {
			$_SESSION['user'] = $user;
			return true;
		} else {
			return false;
		}
	}

	public function getUser_list() {
		die("lol");
		// D'abords on crée le modèle^d'un utilisateur
		// Puis on récupète les utilisateur avec le modèle listUser comme fonction
	}
}