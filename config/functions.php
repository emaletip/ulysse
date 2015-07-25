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
			$_SESSION['flash']['login']['key'] = 'success';
			$_SESSION['flash']['login']['msg'] = '<b>Félicitations ! </b> Vous êtes maintenant connecté(e).';
			$_SESSION['flash']['login']['time'] = time() + 1;
			$_SESSION['loged'] = true;
		}
		return true;
	}
}

function is_url_dashboard() {
	$url = str_replace('/'.PROJECT_DIRECTORY,'',$_SERVER['REQUEST_URI']);
	$url_arr = explode('/', $url);
	if($url_arr[0] == 'dashboard' ) {
		return true;
	} 
	return false;	
}

function is_admin() {
	$logged = is_loged();
	if($logged) {
		if($_SESSION['user']->role_id == 3 && is_url_dashboard()){
			redirect('index');
		}
	}
}

function redirect($path) {
	header('Location: http://'.$_SERVER["HTTP_HOST"].'/'.PROJECT_DIRECTORY.$path);
}

function show_flash($res, $msg_true = '<b>Félicitations ! </b> Vos données ont bien été enregistrées.', $msg_false, $red_true, $red_false){
	if ($res === true) {
		$_SESSION['flash']['user']['key'] = 'success';
		$_SESSION['flash']['user']['msg'] = $msg_true;
		$_SESSION['flash']['user']['time'] = time() + 1;
		
		if($red_true) {
			redirect($red_true);
		}
	} else {
		$_SESSION['flash']['user']['key'] = 'danger';
		if($msg_false){
			$_SESSION['flash']['user']['msg'] = '<b>Attention ! </b> Il y a eu une erreur lors de la sauvegarde de vos données.';
		} else {
			$_SESSION['flash']['user']['msg'] = '';
			foreach ($res as $v) {
				$_SESSION['flash']['user']['msg'] .= $v.'<br>';
			}
		}
		$_SESSION['flash']['user']['time'] = time() + 1;
		
		if($red_false) {
			redirect($red_false);
		}
	}
}

function handleFile($file, $path) {
	$img_path = 'public/img/'.$path;
	$path = __DIR__.'/../public/img/'.$path;
    if (!empty($file) && $file["name"] != '') {
        if (!is_dir($path)) {
            if (!mkdir($path, 0755)) {
                exit('Erreur : le répertoire cible ne peut-être créé ! Vérifiez que vous disposiez des droits suffisants pour le faire ou créez le manuellement !');
            }
        } else {
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $name = md5(uniqid()) . '.' . $extension;
            $image_path = str_replace('../', '', $path) . '/' . $name;			

            if (move_uploaded_file($file['tmp_name'], $path . '/' . $name)) {
                $message = 'Upload réussi !';
                return $img_path. '/' .$name;
            } else {
                // Sinon on affiche une erreur systeme
                $message = 'Problème lors de l\'upload !';
                return $message;
            }
        }
    } else {
        return false;
    }
}

