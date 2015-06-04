<?php

function is_loged(){
	$location = '';
	if(!isset($_SESSION) || !isset($_SESSION['user'])){
		if (strpos($_SERVER["REQUEST_URI"],'dashboard') !== false) {
		    $location = 'dashboard/';
		}
		header('Location: http://'.$_SERVER["HTTP_HOST"].'/'.PROJECT_DIRECTORY.$location.'login');
	
	} else {
		if(!isset($_SESSION['loged'])) {
			$_SESSION['flash']['success'] = 'GG t’es co maggle';
			$_SESSION['loged'] = true;
		}
		return true;
	}
}

function is_admin() {
	$logged = is_loged();
	if($logged) {
		// verif si admin sinon jarté
	}
}