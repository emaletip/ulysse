<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Préparation d'Ulysse</title>
        
        <link rel="stylesheet" href="vendor/css/bootstrap.min.css">
        <link rel="stylesheet" href="vendor/css/bootstrap-theme.min.css">
        <script src="vendor/js/jquery-2.1.4.min.js"></script>
        <script src="vendor/js/bootstrap.min.js"></script>
        
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
    $config = '';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        (!empty($_POST['host'])) ? $host = $_POST['host'] : $errors .= '<p>Veuillez renseigner l\'hôte</p>';
        (!empty($_POST['dbname'])) ? $dbname = $_POST['dbname'] : $errors .= '<p>Veuillez renseigner le nom de la base de données</p>';
        (!empty($_POST['user'])) ? $user = $_POST['user'] : $errors .= '<p>Veuillez renseigner l\'utilisateur</p>';
        (!empty($_POST['mdp'])) ? $mdp = $_POST['mdp'] : $mdp = '';
        (!empty($_POST['path'])) ? $path = $_POST['path'] : $path = '';
            
        if($errors == ''){

            try {
                
                $roles = array("root", "administrateur", "inscrit");

                $db = new PDO('mysql:host='.$host, $user, $mdp);
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                /* Création de la BDD */
                $create_db = $db->prepare('CREATE DATABASE IF NOT EXISTS `'.$dbname.'` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci');
                $create_db->execute();

                $db->query('USE `'.$dbname.'`');

                $tables = array(

                    'CREATE TABLE IF NOT EXISTS `block` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `name` varchar(45) NOT NULL,
                      `is_editable` tinyint(1) NOT NULL,
                      `content_type_id` int(11) NOT NULL,
                      `emplacement_id` int(11) NOT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1',

                    'CREATE TABLE IF NOT EXISTS `config` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `sitename` varchar(100) NOT NULL,
                      `slogan` varchar(255) NOT NULL,
                      `logo` varchar(255) NOT NULL,
                      `copyright` varchar(255) NOT NULL,
                      `is_maintenance` varchar(45) NOT NULL,
                      `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                      `updated_date` timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\',
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1',

                    'CREATE TABLE IF NOT EXISTS `content` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `content_type_name` varchar(100) NOT NULL,
                      `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                      `created_user` int(11) NOT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1',

                    'CREATE TABLE IF NOT EXISTS `content_type` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `name` varchar(100) DEFAULT NULL,
                      PRIMARY KEY (`id`),
                      UNIQUE KEY `name_UNIQUE` (`name`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1',

                    'CREATE TABLE IF NOT EXISTS `emplacement` (
                      `id` int(11) NOT NULL,
                      `name` varchar(45) NOT NULL,
                      `nb_column` int(11) DEFAULT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8',

                    'CREATE TABLE IF NOT EXISTS `field` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `label` varchar(255) NOT NULL,
                      `type` varchar(100) NOT NULL,
                      `size_min` int(11) DEFAULT \'0\',
                      `size_max` int(11) DEFAULT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3',

                    'CREATE TABLE IF NOT EXISTS `field_description` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `content_id` int(11) NOT NULL,
                      `content_description` text NOT NULL,
                      `content_type_name` varchar(100) NOT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1',

                    'CREATE TABLE IF NOT EXISTS `field_title` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `content_id` int(11) NOT NULL,
                      `content_title` varchar(255) NOT NULL,
                      `content_type_name` varchar(100) NOT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1',

                    'CREATE TABLE IF NOT EXISTS `order` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `user_id` int(11) NOT NULL,
                      `total_price` decimal(10,2) NOT NULL,
                      `product_json` text NOT NULL,
                      `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1',

                    'CREATE TABLE IF NOT EXISTS `right` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `name` varchar(45) DEFAULT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1',

                    'CREATE TABLE IF NOT EXISTS `role` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `name` varchar(45) DEFAULT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1',

                    'CREATE TABLE IF NOT EXISTS `role_right` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `right_id` int(11) NOT NULL,
                      `role_id` int(11) NOT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1',

                    'CREATE TABLE IF NOT EXISTS `user` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `email` varchar(255) NOT NULL,
                      `login` varchar(255) NOT NULL,
                      `password` varchar(255) NOT NULL,
                      `last_name` varchar(100) NOT NULL,
                      `first_name` varchar(100) NOT NULL,
                      `address1` varchar(255) NOT NULL,
                      `address2` varchar(255) NOT NULL,
                      `postal_code` smallint(6) NOT NULL,
                      `city` varchar(100) NOT NULL,
                      `country` varchar(100) NOT NULL,
                      `path` varchar(255) NOT NULL,
                      `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1',

                    'CREATE TABLE IF NOT EXISTS `user_role` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `user_id` int(11) NOT NULL,
                      `role_id` int(11) NOT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1'

                );

                foreach($tables as $table)
                {
                    $create_table = $db->prepare($table);
                    $create_table->execute();
                }
                
                foreach($roles as $role)
                {
                    $query = 'INSERT INTO role (name) VALUES (\''.$role.'\')';
                    $db->exec($query);
                }

                $ini = fopen("config/config.ini", "a+");
                $config .= "[db]\r\n";
                $config .= "dsn = \"mysql:dbname=".$dbname.";host=".$host."\"\r\n";
                $config .= "host = ".$host."\r\n";
                $config .= "dbname = ".$dbname."\r\n";
                $config .= "user = ".$user."\r\n";
                $config .= "password = ".$mdp."\r\n";

                $config .= "[path]\r\n";
                $config .= "projectpath = ".$path."\r\n";

                $config .= "[install]\r\n";
                $config .= "install = 0";
                if(fwrite($ini, $config) === FALSE)
                {
                    $errors .= '<p>La création du fichier de configuration a échoué.</p>';
                }
                fclose($ini);

                $validation = 1;

            }
            catch(PDOException $e) {
                $errors .= '<p>Erreur sur la base de données : ' . $e->getMessage() . '</p>';
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
                <h3 class="panel-title">Création de la base de données</h3>
            </div>
        <div class="panel-body">
        
            <p>
            Bienvenue sur le script de configuration d\'Ulysse. Veuillez renseigner les champs pour continuer.
            </p>
        
            <form class="form-horizontal" method="post">

                <div class="form-group">
                    <label for="host" class="col-sm-4 control-label">Hôte *</label>
                    <div class="col-sm-8"><input type="text" class="form-control" name="host"></div>
                </div>

                <div class="form-group">
                    <label for="dbname" class="col-sm-4 control-label">Nom de la BDD *</label>
                    <div class="col-sm-8"><input type="text" class="form-control" name="dbname"></div>
                </div>
                
                <div class="form-group">
                    <label for="user" class="col-sm-4 control-label">Utilisateur *</label>
                    <div class="col-sm-8"><input type="text" class="form-control" name="user"></div>
                </div>
                
                <div class="form-group">
                    <label for="mdp" class="col-sm-4 control-label">Mot de passe *</label>
                    <div class="col-sm-8"><input type="password" class="form-control" name="mdp"></div>
                </div>
                
                <div class="form-group">
                    <label for="path" class="col-sm-4 control-label">Nom du sous-dossier</label>
                    <div class="col-sm-8"><input type="text" class="form-control" name="path"></div>
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
                <h3 class="panel-title">Création de la base de données</h3>
            </div>
        <div class="panel-body">
        
            <p>La base de données à été correctement créée ! Passons à l\'étape suivante.</p>
            <p style="text-align:center;"><a class="btn btn-primary" href="index.php" role="button">Poursuivre l\'installation</a></p>
            
            
        </div>';
        
    }
    ?>

    </div>
    </div>
    </div> <!-- /container -->
    
    </body>
</html>