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
			$_SESSION['flash']['login']['time'] = time() + 2;
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

function redirect($path) {
	header('Location: http://'.$_SERVER["HTTP_HOST"].'/'.PROJECT_DIRECTORY.$path);
}

function handleFile($file, $path) {
	$path = __DIR__.'/../public/img'.$path;
    var_dump($path);
    if (!empty($file) && $file["name"] != '') {
        if (!is_dir($path)) {
            if (!mkdir($path, 0755)) {
                exit('Erreur : le répertoire cible ne peut-être créé ! Vérifiez que vous disposiez des droits suffisants pour le faire ou créez le manuellement !');
            }
        } else {
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $name = md5(uniqid()) . '.' . $extension;
            $image_path = str_replace('../', '', $path) . '/' . $name;
            // Si c'est OK, on teste l'upload
            if (move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $name)) {
                $message = 'Upload réussi !';
                return $image_path;
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

