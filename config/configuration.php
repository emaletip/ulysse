<?php

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

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Configuration d'Ulysse</title>
        
        <link rel="stylesheet" href="<?=$base_directory?>/vendor/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?=$base_directory?>/vendor/css/bootstrap-theme.min.css">
        <script src="<?=$base_directory?>/vendor/js/jquery-2.1.4.min.js"></script>
        <script src="<?=$base_directory?>/vendor/js/bootstrap.min.js"></script>
        
        <style>
        
            body{
                padding: 20px;   
            }
            
        </style>
        
    </head>

    <body>
        
    <div class="container">
    <div class="row">
    <div class="col-md-6 col-md-offset-3">
        
    <?php

    $validation = 0;
    $errors = '';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

		(!empty($_POST['sitename'])) ? $sitename = $_POST['sitename'] : $errors .= '<p>Veuillez renseigner le nom du site</p>';
		(!empty($_POST['slogan'])) ? $slogan = $_POST['slogan'] : $slogan = '';
		(!empty($_POST['copyright'])) ? $copyright = $_POST['copyright'] : $errors .= '<p>Veuillez renseigner le copyright</p>';
		(!empty($_POST['login'])) ? $login = $_POST['login'] : $errors .= '<p>Veuillez renseigner le login</p>';
		(!empty($_POST['email'])) ? $email = $_POST['email'] : $errors .= '<p>Veuillez renseigner l\'email</p>';
		(!empty($_POST['mdp'])) ? $mdp = sha1($_POST['mdp']) : $errors .= '<p>Veuillez renseigner le mot de passe</p>';
        
		$logo =  handleFile($_FILES['logo'],'Config');

        if($errors == ''){
            
            try{
                
                $ini_array = parse_ini_file("config/config.ini");
                
                $db = new PDO('mysql:host='.$ini_array['host'].';dbname='.$ini_array['dbname'].'', $ini_array['user'], $ini_array['password']);
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                $config = $db->prepare('INSERT INTO config (sitename, slogan, logo, copyright, is_maintenance) VALUES (:sitename, :slogan, :logo, :copyright, :is_maintenance)');
                $config->bindParam(':sitename', $sitename);
                $config->bindParam(':slogan', $slogan);
                $config->bindParam(':logo', $logo);
                $config->bindParam(':copyright', $copyright);
                $config->bindValue(':is_maintenance', 0);
                $config->execute();
                
                $root = $db->prepare('INSERT INTO user (login, email, password) VALUES (:login, :email, :password)');
                $root->bindParam(':login', $login);
                $root->bindParam(':email', $email);
                $root->bindParam(':password', $mdp);
                $root->execute();
                
                $db->exec('INSERT INTO user_role (user_id, role_id) VALUES (\'1\', \'1\')');
                
                $handle = fopen("config/config.ini", "a+");
                fseek($handle, 1, SEEK_END);
                fwrite($handle, '1');
                fclose($handle);
                
                $validation = 1;
                
            }
            catch(PDOException $e) {
                $errors .= 'Erreur sur la base de données : ' . $e->getMessage();
            }
            
        }
    }
            
    if($errors != '')
    {
        print '<div class="alert alert-danger" role="alert">';
        print $errors;
        print '</div>';
    }
        
    if($validation == 0){
        print '
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Configuration basique d\'Ulysse</h3>
            </div>
        <div class="panel-body">
        
            <p>
            Veuillez renseigner les champs pour continuer.
            </p>
        
            <form class="form-horizontal" method="post" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="sitename" class="col-sm-4 control-label">Nom du site *</label>
                    <div class="col-sm-8"><input type="text" class="form-control" name="sitename"></div>
                </div>

                <div class="form-group">
                    <label for="slogan" class="col-sm-4 control-label">Slogan</label>
                    <div class="col-sm-8"><input type="text" class="form-control" name="slogan"></div>
                </div>
                
                <div class="form-group">
                    <label for="logo" class="col-sm-4 control-label">Logo (50x50)</label>
                    <div class="col-sm-8"><input type="file" class="form-control" name="logo"></div>
                </div>
                
                <div class="form-group">
                    <label for="copyright" class="col-sm-4 control-label">Copyright *</label>
                    <div class="col-sm-8"><input type="text" class="form-control" name="copyright"></div>
                </div>
                
                <p><em>Compte administrateur pour la gestion du site</em></p>
                
                <div class="form-group">
                    <label for="login" class="col-sm-4 control-label">Pseudonyme *</label>
                    <div class="col-sm-8"><input type="text" class="form-control" name="login"></div>
                </div>
                
                <div class="form-group">
                    <label for="email" class="col-sm-4 control-label">Email *</label>
                    <div class="col-sm-8"><input type="text" class="form-control" name="email"></div>
                </div>
                
                <div class="form-group">
                    <label for="mdp" class="col-sm-4 control-label">Mot de passe *</label>
                    <div class="col-sm-8"><input type="password" class="form-control" name="mdp"></div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-10 col-sm-2 pull-right"><button type="submit" class="btn btn-default">Valider</button></div>
                </div>
            </form>
        </div>
        ';
    }
    else {
        
        print '
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Configuration basique d\'Ulysse</h3>
            </div>
        <div class="panel-body">
        
            <p>La configuration a été enregistrée. Vous pouvez dès à présent utiliser le site !</p>
            <p style="text-align:center;"><a class="btn btn-primary" href="'.$base_directory.'" role="button">Aller sur le site</a></p>
            
            
        </div>';
        
    }

    ?>

    </div>
    </div>
    </div> <!-- /container -->
    
    </body>
</html>