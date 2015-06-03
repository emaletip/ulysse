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
        (!empty($_POST['user'])) ? $user = $_POST['user'] : $errors .= '<p>Veuillez renseigner l\'utilisateur</p>';
        (!empty($_POST['mdp'])) ? $mdp = $_POST['mdp'] : $errors .= '<p>Veuillez renseigner le mot de passe</p>';
        (!empty($_POST['copyright'])) ? $copyright = $_POST['copyright'] : $errors .= '<p>Veuillez renseigner le copyright</p>';
        
        $logo = '';

        if($errors == ''){
            
            try{
                
                $ini_array = parse_ini_file("config/config.ini");
                
                $db = new PDO('mysql:host='.$ini_array['host'].';dbname='.$ini_array['dbname'].'', $ini_array['user'], $ini_array['password']);
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                $update = $db->prepare('INSERT INTO config (sitename, slogan, logo, copyright, is_maintenance) VALUES (:sitename, :slogan, :logo, :copyright, :is_maintenance)');
                $update->bindParam(':sitename', $sitename);
                $update->bindParam(':slogan', $slogan);
                $update->bindParam(':logo', $logo);
                $update->bindParam(':copyright', $copyright);
                $update->bindValue(':is_maintenance', 0);
                $update->execute();
                
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
        
            <form class="form-horizontal" method="post">

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
                    <label for="user" class="col-sm-4 control-label">Login *</label>
                    <div class="col-sm-8"><input type="text" class="form-control" name="user"></div>
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
            <p style="text-align:center;"><a class="btn btn-primary" href="index" role="button">Aller sur le site</a></p>
            
            
        </div>';
        
    }
    ?>

    </div>
    </div>
    </div> <!-- /container -->
    
    </body>
</html>