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
                      `title` varchar(255) NULL,
                      `is_active` tinyint(1) NOT NULL,
                      `is_editable` tinyint(1) NOT NULL,
                      `content_block` text NOT NULL,
                      `emplacement_id` int(11) NOT NULL,
                      `position` int(11) NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1',
                    
                    'CREATE TABLE IF NOT EXISTS `category` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `name` varchar(100) NOT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1',

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
                    
                    'CREATE TABLE IF NOT EXISTS `content_field` (
                      `content_type_id` int(11) NOT NULL,
                      `field_id` int(11) NOT NULL
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8',
                    
                    'CREATE TABLE IF NOT EXISTS `content_menu` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `content_id` int(11) NOT NULL,
                      `menu_id` int(11) NOT NULL,
                      `parent_id` int(11) DEFAULT NULL,
                      `position` int(11) NOT NULL,
                      `path` varchar(255) NOT NULL,
                      `type` varchar(255) NOT NULL,
                      `label` varchar(255) NOT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1',
                    
                    'CREATE TABLE IF NOT EXISTS `content_tag` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `content_id` int(11) NOT NULL,
                      `tag_id` int(11) NOT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1',

                    'CREATE TABLE IF NOT EXISTS `content_type` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `name` varchar(100) DEFAULT NULL,
                      PRIMARY KEY (`id`),
                      UNIQUE KEY `name_UNIQUE` (`name`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1',

                    'CREATE TABLE IF NOT EXISTS `emplacement` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `name` varchar(45) NOT NULL,
                      `nb_column` int(11) DEFAULT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1',

                    'CREATE TABLE IF NOT EXISTS `field` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `name` varchar(255) NOT NULL,
                      `label` varchar(255) NOT NULL,
                      `type` varchar(100) NOT NULL,
                      `size_min` int(11) DEFAULT \'0\',
                      `size_max` int(11) DEFAULT NULL,
                      `is_active` tinyint(1) NOT NULL,
                      `custom` tinyint(1) NOT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1',
                    
                    'CREATE TABLE IF NOT EXISTS `field_body` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `field_id` int(11) NOT NULL,
                      `content_id` int(11) NOT NULL,
                      `content_body` text NOT NULL,
                      `content_type_name` varchar(100) NOT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1',
                    
                    'CREATE TABLE IF NOT EXISTS `field_caption` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `field_id` int(11) NOT NULL,
                      `content_id` int(11) NOT NULL,
                      `content_caption` varchar(255) NOT NULL,
                      `content_type_name` varchar(100) NOT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1',
                    
                    'CREATE TABLE IF NOT EXISTS `field_category` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `field_id` int(11) NOT NULL,
                      `content_id` int(11) NOT NULL,
                      `content_category` int(11) NOT NULL,
                      `content_type_name` varchar(100) NOT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1',

                    'CREATE TABLE IF NOT EXISTS `field_description` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `field_id` int(11) NOT NULL,
                      `content_id` int(11) NOT NULL,
                      `content_description` text NOT NULL,
                      `content_type_name` varchar(100) NOT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1',
                    
                    'CREATE TABLE IF NOT EXISTS `field_image` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `field_id` int(11) NOT NULL,
                      `content_id` int(11) NOT NULL,
                      `content_image` varchar(255) NOT NULL,
                      `content_type_name` varchar(100) NOT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1',
                    
                    'CREATE TABLE IF NOT EXISTS `field_link` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `field_id` int(11) NOT NULL,
                      `content_id` int(11) NOT NULL,
                      `content_link` varchar(255) NOT NULL,
                      `content_type_name` varchar(100) NOT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1',
                    
                    'CREATE TABLE IF NOT EXISTS `field_path` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `field_id` int(11) NOT NULL,
                      `content_id` int(11) NOT NULL,
                      `content_path` varchar(255) NOT NULL,
                      `content_type_name` varchar(100) NOT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT=\'Image slider\' AUTO_INCREMENT=1',
                    
                    'CREATE TABLE IF NOT EXISTS `field_price` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `field_id` int(11) NOT NULL,
                      `content_id` int(11) NOT NULL,
                      `content_price` decimal(10,2) NOT NULL,
                      `content_type_name` varchar(100) NOT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1',

                    'CREATE TABLE IF NOT EXISTS `field_title` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `field_id` int(11) NOT NULL,
                      `content_id` int(11) NOT NULL,
                      `content_title` varchar(255) NOT NULL,
                      `content_type_name` varchar(100) NOT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1',
                    
                    'CREATE TABLE IF NOT EXISTS `field_stock` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `field_id` int(11) NOT NULL,
                      `content_id` int(11) NOT NULL,
                      `content_stock` int(11) NOT NULL,
                      `content_type_name` varchar(100) NOT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1',
                    
                    'CREATE TABLE IF NOT EXISTS `menu` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `label` varchar(100) NOT NULL,
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
                    
                    'CREATE TABLE IF NOT EXISTS `tag` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `name` varchar(255) NOT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1',

                    'CREATE TABLE IF NOT EXISTS `user` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `email` varchar(255) NOT NULL,
                      `login` varchar(255) NOT NULL,
                      `password` varchar(255) NOT NULL,
                      `avatar` varchar(255) NOT NULL,
                      `last_name` varchar(100) NOT NULL,
                      `first_name` varchar(100) NOT NULL,
                      `address1` varchar(255) NOT NULL,
                      `address2` varchar(255) NOT NULL,
                      `postal_code` int(11) NOT NULL,
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
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1',
                    
                    'CREATE TABLE IF NOT EXISTS `cart` (
					  `id` INT NOT NULL,
					  `user_id` INT NULL,
					  `product_id` INT NULL,
					  `quantity` INT NULL,
					  `created_date` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
					  PRIMARY KEY (`id`)
					  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1',
                    
                    
                    'INSERT INTO `block` (`id`, `name`, `title`, `is_active`, `is_editable`, `content_block`, `emplacement_id`, `position`) VALUES
                    (1, \'block_logo\', \'Logo\', 1, 0, \'\', 4, 1),
					(2, \'block_connect\', \'Connection\', 1, 0, \'\', 1, 1),
					(3, \'block_cart\', \'Panier\', 1, 0, \'\', 2, 1),
					(4, \'block_search\', \'Rechercher\', 1, 0, \'\', 3, 1),
					(5, \'block_principal_menu\', \'Menu principal\', 1, 0, \'\', 4, 2),
					(6, \'block_content\', \'Contenu\', 1, 0, \'\', 8, 0),
					(7, \'block_top_sell\', \'Meilleures ventes\', 0, 0, \'\', 7, 0),
					(8, \'block_informations\', \'A propos\', 1, 1, \'<div class="Texte" id="TheTexte">\r\n<p><strong>Sed tamen haec cum ita tutius observentur, </strong></p>\r\n\r\n<p>quidam vigore artuum inminuto rogati ad nuptias ubi aurum dextris manibus cavatis offertur, inpigre vel usque Spoletium pergunt. haec nobilium sunt instituta.</p>\r\n</div>\r\n\', 10, 2),
					(9, \'block_secondary_menu\', \'Menu secondaire\', 0, 0, \'\', 4, 0),
					(10, \'block_copyright\', \'\', 1, 1, \'Copyright 2015 - Contenu bloc copyright\', 11, 2),
					(11, \'block_slider\', \'Slider\', 1, 0, \'\', 5, 2),
					(12, \'block_article\', \'Derniers articles\', 1, 0, \'\', 10, 1),
					(13, \'block_contact\', \'CoordonnÃ©es\', 1, 1, \'<p><strong>Tel.</strong> +33(0) 606 060 606</p>\r\n\r\n<p><strong>Mobile.</strong> +33(0) 606 060 606</p>\r\n\r\n<p>Adresse rue<br />\r\n00000 Ville</p>\r\n\', 10, 3),
					(14, \'block_filter\', \'Recherche filtrÃ©e\', 1, 0, \'\', 7, 1)',
                    
                    'INSERT INTO `category` (`id`, `name`) VALUES
                    (1, \'Mobilier\'),
                    (2, \'Nourriture\'),
                    (3, \'Informatique\')',
                    
                    'INSERT INTO `emplacement` (`id`, `name`, `nb_column`) VALUES
                    (1, \'Header Left\', 1),
                    (2, \'Header Right\', 1),
                    (3, \'Header Center\', 1),
                    (4, \'Menu\', 1),
                    (5, \'Slider\', 1),
                    (6, \'Before Content\', 3),
                    (7, \'Sidebar\', 1),
                    (8, \'Content\', 1),
                    (9, \'Pre Footer\', 3),
                    (10, \'Footer\', 3),
                    (11, \'Copyright\', 1)',
                    
                    'INSERT INTO content (`content_type_name`, `created_user`) VALUES
                    (\'page\', 1),
                    (\'article\', 1),
                    (\'product\', 1),
                    (\'product\', 1),
                    (\'slider\', 1),
                    (\'slider\', 1);',
                    
                    'INSERT INTO menu (`label`) VALUES
                    (\'principal\'),
                    (\'secondaire\')',
                    
                    'INSERT INTO `content_menu` (`id`, `content_id`, `menu_id`, `parent_id`, `path`, `type`, `label`, `position`) VALUES
					(1, 0, 1, NULL, \'/index\', \'link\', \'Accueil\', 1),
					(2, 1, 1, NULL, NULL, \'category\', \'Mobilier\', 2),
					(5, 1, 1, 2, NULL, \'page\', \'Salon\', 1),
					(8, 1, 2, NULL, NULL, \'category\', \'Mob\', NULL),
					(9, 1, 2, 8, NULL, \'page\', \'Test\', 1),
					(10, 0, 1, NULL, \'/contact\', \'link\', \'Contact\', 6);',
                    
                    'INSERT INTO `content_field` (`content_type_id`, `field_id`) VALUES
                    (4, 1),
                    (4, 3),
                    (4, 4),
                    (4, 5),
                    (4, 9),
                    (4, 10),
                    (3, 1),
                    (3, 3),
                    (3, 6),
                    (3, 7),
                    (3, 8)',
                    
                    'INSERT INTO `content_tag` (`id`, `content_id`, `tag_id`) VALUES
                    (1, 3, 1),
                    (2, 4, 1),
                    (3, 4, 2)',
                
                    'INSERT INTO content_type (`name`) VALUES
                    (\'page\'),
                    (\'article\'),
                    (\'slider\'),
                    (\'product\')',

                    'INSERT INTO `field` (`id`, `name`, `label`, `type`, `size_min`, `size_max`, `custom`) VALUES
                    (1, \'field_title\', \'Titre\', \'input_text\', 10, 200, 0),
                    (2, \'field_body\', \'Body\', \'textarea\', 0, NULL, 0),
                    (3, \'field_description\', \'Description\', \'textarea\', 0, NULL, 0),
                    (4, \'field_category\', \'Catégorie\', \'select\', 0, NULL, 0),
                    (5, \'field_price\', \'Prix\', \'input_decimal\', 3, NULL, 0),
                    (6, \'field_caption\', \'Sous-titre\', \'input_text\', 0, NULL, 0),
                    (7, \'field_path\', \'Image (Slider)\', \'input_file\', 0, NULL, 0),
                    (8, \'field_link\', \'Lien (Slider)\', \'input_text\', 0, NULL, 0),
                    (9, \'field_stock\', \'Stock\', \'input_text\', 0, NULL, 0),
                    (10, \'field_image\', \'Image\', \'input_file\', 0, NULL, 0)',

                    'INSERT INTO `field_body` (`id`, `field_id`, `content_id`, `content_body`, `content_type_name`) VALUES
                    (1, 2, 1, \'Ut enim benefici liberalesque sumus, non ut exigamus gratiam (neque enim beneficium faeneramur sed natura propensi ad liberalitatem sumus), sic amicitiam non spe mercedis adducti sed quod omnis eius fructus in ipso amore inest, expetendam putamus.\', \'page\'),
                    (2, 2, 2, \'Quae amicitia voluntatibus aut sententia acceperit est aequo neque affluentior.\', \'article\')',
                    
                    'INSERT INTO `field_description` (`id`, `field_id`, `content_id`, `content_description`, `content_type_name`) VALUES
                    (1, 4, 3, \'La nucléarité des rollers\', \'product\'),
                    (2, 4, 4, \'Mais oui cest clair !\', \'product\'),
					(3, 3, 5, \'\', \'slider\'),
					(4, 3, 6, \'\', \'slider\')',
                    
                    'INSERT INTO `field_price` (`id`, `field_id`, `content_id`, `content_price`, `content_type_name`) VALUES
                    (1, 4, 3, \'10.50\', \'product\'),
                    (2, 4, 4, \'13.25\', \'product\')',
                    
                    'INSERT INTO `field_stock` (`id`, `field_id`, `content_id`, `content_stock`, `content_type_name`) VALUES
                    (1, 4, 3, \'10\', \'product\'),
                    (2, 4, 4, \'13\', \'product\')',
                    
                    'INSERT INTO `field_category` (`id`, `field_id`, `content_id`, `content_category`, `content_type_name`) VALUES
                    (1, 4, 3, \'1\', \'product\'),
                    (2, 4, 4, \'2\', \'product\')',
                    
                    'INSERT INTO `field_image` (`id`, `field_id`, `content_id`, `content_image`, `content_type_name`) VALUES
                    (1, 4, 3, \'\', \'product\'),
                    (2, 4, 4, \'\', \'product\')',

                    'INSERT INTO `field_title` (`id`, `field_id`, `content_id`, `content_title`, `content_type_name`) VALUES
                    (1, 1, 1, \'Page de base\', \'page\'),
                    (2, 1, 2, \'Nouvelle !\', \'article\'),
                    (3, 1, 3, \'Premier produit\', \'product\'),
                    (4, 1, 4, \'Second produit\', \'product\'),
					(6, 1, 5,\'Le chat\',\'slider\'),
					(7, 1, 6,\'Un chat 2\',\'slider\')',
                    
                    'INSERT INTO `field_caption` (`id`,`field_id`,`content_id`,`content_caption`,`content_type_name`) VALUES 
					(1,6,5,\'Joli chat\',\'slider\'),
					(2,6,6,\'Piti piti\',\'slider\')',
                    
                    'INSERT INTO `field_link` (`id`,`field_id`,`content_id`,`content_link`,`content_type_name`) VALUES 
					(1,8,5,\'index\',\'slider\'),
					(2,8,6,\'page/21\',\'slider\')',
                    
                    'INSERT INTO `field_path` (`id`,`field_id`,`content_id`,`content_path`,`content_type_name`) VALUES 
					(1,1,5,\'public/img/Slider/be954d3f236da02e970314e2e1852e65.jpg\',\'slider\'),
					(2,1,6,\'public/img/Slider/5ed2bd8ac95739929f6699a68aac38fc.jpg\',\'slider\')',
                    
                    'INSERT INTO role (`name`) VALUES
                    (\'root\'),
                    (\'administrateur\'),
                    (\'inscrit\')',
                    
                    'INSERT INTO `tag` (`id`, `name`) VALUES
                    (1, \'Chaise\'),
                    (2, \'Table\'),
                    (3, \'Fruit\')',

                );

                foreach($tables as $table) {
                    $create_table = $db->prepare($table);
                    $create_table->execute();
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