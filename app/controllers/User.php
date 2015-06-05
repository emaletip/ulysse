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
			$userModel->setId($user['id'])
					->setEmail($user['email'])
					->setPassword($user['password'])
					->setLast_name($user['last_name'])
					->setFirst_name($user['first_name'])
					->setAddress1($user['address1'])
					->setAddress2($user['address2'])
					->setPostal_code($user['postal_code'])
					->setCity($user['city'])
					->setCountry($user['country'])
					->setPath($user['path'])
					->setCreated_date($user['created_date']);
					
			$_SESSION['user'] = $userModel;
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