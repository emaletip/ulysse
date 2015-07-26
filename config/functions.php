<?php

function is_loged(){
	$location = '';
	if(!isset($_SESSION) || !isset($_SESSION['user'])){
		if(!is_url_dashboard()){
			return false;
		}
		if (strpos($_SERVER["REQUEST_URI"],'dashboard') !== false) {
		    $location = 'dashboard/';
		}
		header('Location: http://'.$_SERVER["HTTP_HOST"].'/'.PROJECT_DIRECTORY.$location.'login');
	} else {
		if(!isset($_SESSION['loged'])) {
			$_SESSION['loged'] = true;
			show_flash(true,'<b>Félicitations ! </b> Vous êtes maintenant connecté(e).',false,false,false);
		}
		return true;
	}
}

function parent_url(){
	$parent = str_replace('http://','',$_SERVER['HTTP_REFERER']);
	$parent = str_replace($_SERVER['HTTP_HOST'], '', $parent);
	return trim(str_replace(PROJECT_DIRECTORY,'', $parent),'/');
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
	if($logged && is_url_dashboard()) {
		if($_SESSION['user']->role_id == 3 && is_url_dashboard()){
			return false;
		}
		return true;
	} else if ($logged && !is_url_dashboard()) {
		if($_SESSION['user']->role_id == 3){
			return false;
		}
		return true;
	}
	return false;
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
			if($msg_false == '') {				
				$_SESSION['flash']['user']['msg'] = '<b>Attention ! </b> Il y a eu une erreur lors de la sauvegarde de vos données.';
			} else {
				$_SESSION['flash']['user']['msg'] = $msg_false;
			}
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
            $nameid = md5(uniqid());
            $name =  $nameid . '.' . $extension;
            $image_path = $path . '/' . $name;	
            
            $create_img = move_uploaded_file($file['tmp_name'], $path . '/' . $name);

            $largeur = 200;
			$hauteur = 200;
			 
			$image = imagecreatefromjpeg($image_path);
			$taille = getimagesize($image_path);
			 
			$sortie = imagecreatetruecolor($largeur,$hauteur);
			 
			$coef = min($taille[0]/$largeur,$taille[1]/$hauteur);
			 
			$deltax = $taille[0]-($coef * $largeur); 
			$deltay = $taille[1]-($coef * $hauteur);
			 
			imagecopyresampled($sortie,$image,0,0,$deltax/2,$deltay/2,$largeur,$hauteur,$taille[0]-$deltax,$taille[1]-$deltay);			 
			$avatar = imagejpeg($sortie,$path.'/'.$nameid.'-200x200.'.$extension,100);
            		
            if ($create_img) {
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

function get_avatar($avatar){
	if($avatar) {
		$path_parts = pathinfo($avatar);
		$ext = '.'.$path_parts['extension'];
		$name = str_replace($ext,'',$path_parts['basename']).'-200x200';
		
		if(file_exists($path_parts['dirname'].'/'.$name.$ext)) {
			$avatar = '/'.PROJECT_DIRECTORY.$path_parts['dirname'].'/'.$name.$ext;
		} 
		 
	} else {
		$avatar = FRONT_IMG_PATH.'default_avatar.gif';
	}
	

	return $avatar;
}