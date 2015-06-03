<?php

function is_loged(){
	$location = '';
	if(!isset($_SESSION) || !isset($_SESSION['user'])){
		$api = new \config\Router\Api();

		if (strpos($_SERVER["REQUEST_URI"],'dashboard') !== false) {
		    $location = 'dashboard/';
		}

		$api->getResponse()->redirect('/'.PROJECT_DIRECTORY.$location.'login');
	
	} else {
		return true;
	}
}

function is_admin() {
	$logged = is_loged();
	if($logged) {
		// verif si admin sinon jarté
	}
}