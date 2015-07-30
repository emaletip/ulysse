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
            	
                $db = new PDO('mysql:host='.$host, $user, $mdp, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

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
                    ) ENGINE=InnoDB DEFAULT charset=utf8 AUTO_INCREMENT=1',
                    
                    'CREATE TABLE IF NOT EXISTS `category` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `name` varchar(100) NOT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB  DEFAULT charset=utf8 AUTO_INCREMENT=1',

                    'CREATE TABLE IF NOT EXISTS `config` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `sitename` varchar(100) NOT NULL,
                      `slogan` varchar(255) NOT NULL,
                      `logo` varchar(255) NULL,
                      `copyright` varchar(255) NOT NULL,
                      `is_maintenance` varchar(45) NOT NULL,
                      `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                      `updated_date` timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\',
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB  DEFAULT charset=utf8 AUTO_INCREMENT=1',

                    'CREATE TABLE IF NOT EXISTS `content` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `content_type_name` varchar(100) NOT NULL,
                      `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                      `created_user` int(11) NOT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT charset=utf8 AUTO_INCREMENT=1',
                    
                    'CREATE TABLE IF NOT EXISTS `content_field` (
                      `content_type_id` int(11) NOT NULL,
                      `field_id` int(11) NOT NULL
                    ) ENGINE=InnoDB DEFAULT charset=utf8',
                    
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
                    ) ENGINE=InnoDB  DEFAULT charset=utf8 AUTO_INCREMENT=1',
                    
                    'CREATE TABLE IF NOT EXISTS `content_select` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `name` varchar(255) NOT NULL,
                      `field_name` varchar(100) NOT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT charset=utf8 AUTO_INCREMENT=1',
                    
                    'CREATE TABLE IF NOT EXISTS `content_tag` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `content_id` int(11) NOT NULL,
                      `tag_id` int(11) NOT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB  DEFAULT charset=utf8 AUTO_INCREMENT=1',

                    'CREATE TABLE IF NOT EXISTS `content_type` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `name` varchar(100) DEFAULT NULL,
                      PRIMARY KEY (`id`),
                      UNIQUE KEY `name_UNIQUE` (`name`)
                    ) ENGINE=InnoDB DEFAULT charset=utf8 AUTO_INCREMENT=1',

                    'CREATE TABLE IF NOT EXISTS `emplacement` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `name` varchar(45) NOT NULL,
                      `nb_column` int(11) DEFAULT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB  DEFAULT charset=utf8 AUTO_INCREMENT=1',

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
                    ) ENGINE=InnoDB  DEFAULT charset=utf8 AUTO_INCREMENT=1',
                    
                    'CREATE TABLE IF NOT EXISTS `field_body` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `field_id` int(11) NOT NULL,
                      `content_id` int(11) NOT NULL,
                      `content_body` text NOT NULL,
                      `content_type_name` varchar(100) NOT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB  DEFAULT charset=utf8 AUTO_INCREMENT=1',
                    
                    'CREATE TABLE IF NOT EXISTS `field_caption` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `field_id` int(11) NOT NULL,
                      `content_id` int(11) NOT NULL,
                      `content_caption` varchar(255) NOT NULL,
                      `content_type_name` varchar(100) NOT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT charset=utf8 AUTO_INCREMENT=1',
                    
                    'CREATE TABLE IF NOT EXISTS `field_category` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `field_id` int(11) NOT NULL,
                      `content_id` int(11) NOT NULL,
                      `content_category` int(11) NOT NULL,
                      `content_type_name` varchar(100) NOT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT charset=utf8 AUTO_INCREMENT=1',

                    'CREATE TABLE IF NOT EXISTS `field_description` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `field_id` int(11) NOT NULL,
                      `content_id` int(11) NOT NULL,
                      `content_description` text NOT NULL,
                      `content_type_name` varchar(100) NOT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT charset=utf8 AUTO_INCREMENT=1',
                    
                    'CREATE TABLE IF NOT EXISTS `field_image` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `field_id` int(11) NOT NULL,
                      `content_id` int(11) NOT NULL,
                      `content_image` varchar(255) NOT NULL,
                      `content_type_name` varchar(100) NOT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT charset=utf8 AUTO_INCREMENT=1',
                    
                    'CREATE TABLE IF NOT EXISTS `field_link` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `field_id` int(11) NOT NULL,
                      `content_id` int(11) NOT NULL,
                      `content_link` varchar(255) NOT NULL,
                      `content_type_name` varchar(100) NOT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT charset=utf8 AUTO_INCREMENT=1',
                    
                    'CREATE TABLE IF NOT EXISTS `field_path` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `field_id` int(11) NOT NULL,
                      `content_id` int(11) NOT NULL,
                      `content_path` varchar(255) NOT NULL,
                      `content_type_name` varchar(100) NOT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT charset=utf8 COMMENT=\'Image slider\' AUTO_INCREMENT=1',
                    
                    'CREATE TABLE IF NOT EXISTS `field_price` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `field_id` int(11) NOT NULL,
                      `content_id` int(11) NOT NULL,
                      `content_price` decimal(10,2) NOT NULL,
                      `content_type_name` varchar(100) NOT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT charset=utf8 AUTO_INCREMENT=1',

                    'CREATE TABLE IF NOT EXISTS `field_title` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `field_id` int(11) NOT NULL,
                      `content_id` int(11) NOT NULL,
                      `content_title` varchar(255) NOT NULL,
                      `content_type_name` varchar(100) NOT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT charset=utf8 AUTO_INCREMENT=1',
                    
                    'CREATE TABLE IF NOT EXISTS `field_stock` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `field_id` int(11) NOT NULL,
                      `content_id` int(11) NOT NULL,
                      `content_stock` int(11) NOT NULL,
                      `content_type_name` varchar(100) NOT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT charset=utf8 AUTO_INCREMENT=1',
                    
                    'CREATE TABLE IF NOT EXISTS `menu` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `label` varchar(100) NOT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT charset=utf8 AUTO_INCREMENT=1',

                    'CREATE TABLE IF NOT EXISTS `order` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `user_id` int(11) NOT NULL,
                      `delivery_address` text NOT NULL,
                      `total_price` decimal(10,2) NOT NULL,
                      `delivery_id` int(11) NOT NULL,
                      `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT charset=utf8 AUTO_INCREMENT=1',

                    'CREATE TABLE IF NOT EXISTS `right` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `name` varchar(45) DEFAULT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT charset=utf8 AUTO_INCREMENT=1',

                    'CREATE TABLE IF NOT EXISTS `role` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `name` varchar(45) DEFAULT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT charset=utf8 AUTO_INCREMENT=1',

                    'CREATE TABLE IF NOT EXISTS `role_right` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `right_id` int(11) NOT NULL,
                      `role_id` int(11) NOT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT charset=utf8 AUTO_INCREMENT=1',
                    
                    'CREATE TABLE IF NOT EXISTS `tag` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `name` varchar(255) NOT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB  DEFAULT charset=utf8 AUTO_INCREMENT=1',
                    
                    'CREATE TABLE IF NOT EXISTS `field_active` (
					  `id` INT NOT NULL AUTO_INCREMENT,
					  `field_id` INT NOT NULL,
					  `content_id` INT NOT NULL,
					  `content_active` TINYINT NOT NULL,
					  `content_type_name` VARCHAR(100) NOT NULL,
					  PRIMARY KEY (`id`)
					  ) ENGINE=InnoDB DEFAULT charset=utf8 AUTO_INCREMENT=1',

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
                    ) ENGINE=InnoDB DEFAULT charset=utf8 AUTO_INCREMENT=1',

					 'CREATE TABLE IF NOT EXISTS `user_content` (
					  `id` INT NOT NULL AUTO_INCREMENT,
					  `user_id` INT NOT NULL,
					  `content_id` INT NOT NULL,
					  `content_price` DECIMAL(10,2) NULL,
					  `created_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
					  PRIMARY KEY (`id`)
					  ) ENGINE=InnoDB DEFAULT charset=utf8 AUTO_INCREMENT=1',

                    'CREATE TABLE IF NOT EXISTS `user_role` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `user_id` int(11) NOT NULL,
                      `role_id` int(11) NOT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT charset=utf8 AUTO_INCREMENT=1',
                    
                    'CREATE TABLE IF NOT EXISTS `cart` (
					  `id` INT NOT NULL AUTO_INCREMENT,
					  `user_id` INT NULL,
					  `user_content_id` INT NULL,
					  `product_id` INT NULL,
					  `quantity` INT NULL,
					  `created_date` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
					  PRIMARY KEY (`id`)
					  ) ENGINE=InnoDB DEFAULT charset=utf8 AUTO_INCREMENT=1',
                    
                    'CREATE TABLE IF NOT EXISTS `order_product` (
					 `id` INT NOT NULL AUTO_INCREMENT,
					 `order_id` INT NOT NULL,
					 `user_content_id` INT NOT NULL,
					 `product_id` INT NOT NULL,
					 `quantity` INT NOT NULL,
					 `delivery_status_id` INT NOT NULL,
					 `user_id` INT NOT NULL,
					 PRIMARY KEY (`id`)
					 ) ENGINE=InnoDB DEFAULT charset=utf8 AUTO_INCREMENT=1',
                    
                    'CREATE TABLE IF NOT EXISTS `review` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `content_id` int(11) NOT NULL,
                      `user_id` int(11) NOT NULL,
                      `comment` text NOT NULL,
                      `score` int(11) NOT NULL,
                      `datecreated` datetime NOT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1',
                    
                    'INSERT INTO `block` (`name`, `title`, `is_active`, `is_editable`, `content_block`, `emplacement_id`, `position`) VALUES
                    (\'block_logo\', \'Logo\', 1, 0, \'\', 4, 1),
					(\'block_connect\', \'Connection\', 1, 0, \'\', 1, 1),
					(\'block_cart\', \'Panier\', 1, 0, \'\', 2, 1),
					(\'block_search\', \'Rechercher\', 1, 0, \'\', 3, 1),
					(\'block_principal_menu\', \'Menu principal\', 1, 0, \'\', 4, 2),
					(\'block_content\', \'Contenu\', 1, 0, \'\', 8, 0),
					(\'block_top_sell\', \'Meilleures ventes\', 0, 0, \'\', 7, 0),
					(\'block_informations\', \'A propos\', 1, 1, \'<div class="Texte" id="TheTexte">\r\n<p><strong>Sed tamen haec cum ita tutius observentur, </strong></p>\r\n\r\n<p>quidam vigore artuum inminuto rogati ad nuptias ubi aurum dextris manibus cavatis offertur, inpigre vel usque Spoletium pergunt. haec nobilium sunt instituta.</p>\r\n</div>\r\n\', 10, 2),
					(\'block_secondary_menu\', \'Menu secondaire\', 0, 0, \'\', 4, 0),
					(\'block_copyright\', \'\', 1, 0, \'Copyright 2015 - Contenu bloc copyright\', 11, 2),
					(\'block_slider\', \'Slider\', 1, 0, \'\', 5, 2),
					(\'block_article\', \'Derniers articles\', 1, 0, \'\', 10, 1),
					(\'block_contact\', \'Coordonnées\', 1, 1, \'<p><strong>Tel.</strong> +33(0) 606 060 606</p>\r\n\r\n<p><strong>Mobile.</strong> +33(0) 606 060 606</p>\r\n\r\n<p>Adresse rue<br />\r\n00000 Ville</p>\r\n\', 10, 3),
					(\'block_filter\', \'Recherche filtrée\', 1, 0, \'\', 7, 1)',
                    
                    'INSERT INTO `category` (`name`) VALUES
                    (\'Chambre\'),
                    (\'Salle de bain\'),
                    (\'Salon\'),
                    (\'Cuisine\')',
                    
                    'INSERT INTO `emplacement` (`name`, `nb_column`) VALUES
                    (\'Header Left\', 1),
                    (\'Header Right\', 1),
                    (\'Header Center\', 1),
                    (\'Menu\', 1),
                    (\'Slider\', 1),
                    (\'Before Content\', 3),
                    (\'Sidebar\', 1),
                    (\'Content\', 1),
                    (\'Pre Footer\', 3),
                    (\'Footer\', 3),
                    (\'Copyright\', 1)',
                    
                    'INSERT INTO content (`content_type_name`, `created_user`) VALUES
                    (\'page\', 1),
                    (\'article\', 1),
                    (\'product\', 1),
                    (\'product\', 1),
                    (\'product\', 1),
                    (\'product\', 1),
                    (\'product\', 1),
                    (\'product\', 1),
                    (\'product\', 1),
                    (\'slider\', 1),
                    (\'slider\', 1);',
                    
                    'INSERT INTO menu (`label`) VALUES
                    (\'principal\'),
                    (\'secondaire\')',
                    
/* refaire*/
                    'INSERT INTO `content_menu` 
                    (`id`, `content_id`, `menu_id`, `parent_id`, `path`, `type`, `label`, `position`) VALUES
					(1, 0, 1, NULL, \'/index\', \'link\', \'Accueil\', 1),
					(2, 0, 1, NULL, \'/product\', \'link\', \'Produits\', 1),
					(3, 1, 1, 2, NULL, \'category\', \'Chambre\', 2),
					(4, 2, 1, 2, NULL, \'category\', \'Salle de bain\', 3),
					(5, 3, 1, 2, NULL, \'category\', \'Salon\', 4),
					(6, 4, 1, 2, NULL, \'category\', \'Cuisine\', 5),
					(7, 1, 1, NULL, NULL, \'page\', \'Présentation\', 1),
					(8, 0, 1, NULL, \'/contact\', \'link\', \'Contact\', 1);',                    
                    
                    'INSERT INTO `content_field` (`content_type_id`, `field_id`) VALUES
                    (4, 1),
                    (4, 3),
                    (4, 4),
                    (4, 5),
                    (4, 9),
                    (4, 10),
                    (4, 11),
                    (3, 1),
                    (3, 6),
                    (3, 3),
                    (3, 7),
                    (3, 8)',
                    
                    'INSERT INTO `content_tag` (`content_id`, `tag_id`) VALUES
                    (3, 2),
                    (4, 5),
                    (5, 3),
                    (6, 1),
                    (9, 4)',
                
                    'INSERT INTO content_type (`name`) VALUES
                    (\'page\'),
                    (\'article\'),
                    (\'slider\'),
                    (\'product\')',

                    'INSERT INTO `field` (`name`, `label`, `type`, `size_min`, `size_max`, `custom`) VALUES
                    (\'field_title\', \'Titre\', \'input_text\', 10, 200, 0),
                    (\'field_body\', \'Body\', \'textarea\', 0, NULL, 0),
                    (\'field_description\', \'Description\', \'textarea\', 0, NULL, 0),
                    (\'field_category\', \'Catégorie\', \'select\', 0, NULL, 0),
                    (\'field_price\', \'Prix\', \'input_decimal\', 3, NULL, 0),
                    (\'field_caption\', \'Sous-titre\', \'input_text\', 0, NULL, 0),
                    (\'field_path\', \'Image (Slider)\', \'input_file\', 0, NULL, 0),
                    (\'field_link\', \'Lien (Slider)\', \'input_text\', 0, NULL, 0),
                    (\'field_stock\', \'Stock\', \'input_text\', 0, NULL, 0),
					(\'field_image\', \'Image\', \'input_file\', 0, NULL, 0),
                    (\'field_active\', \'Actif\', \'input_checkbox\', 0, NULL, 0)',

                    'INSERT INTO `field_body` (`field_id`, `content_id`, `content_body`, `content_type_name`) VALUES
                    (2, 1, \'<p>Batnae municipium in Anthemusia conditum Macedonum manu priscorum ab Euphrate flumine brevi spatio disparatur, refertum mercatoribus opulentis, ubi annua sollemnitate prope Septembris initium mensis ad nundinas magna promiscuae fortunae convenit multitudo ad commercanda quae Indi mittunt et Seres aliaque plurima vehi terra marique consueta.</p><p>Quod si rectum statuerimus vel concedere amicis, quidquid velint, vel impetrare ab iis, quidquid velimus, perfecta quidem sapientia si simus, nihil habeat res vitii; sed loquimur de iis amicis qui ante oculos sunt, quos vidimus aut de quibus memoriam accepimus, quos novit vita communis. Ex hoc numero nobis exempla sumenda sunt, et eorum quidem maxime qui ad sapientiam proxime accedunt.</p><p>Quam ob rem vita quidem talis fuit vel fortuna vel gloria, ut nihil posset accedere, moriendi autem sensum celeritas abstulit; quo de genere mortis difficile dictu est; quid homines suspicentur, videtis; hoc vere tamen licet dicere, P. Scipioni ex multis diebus, quos in vita celeberrimos laetissimosque viderit, illum diem clarissimum fuisse, cum senatu dimisso domum reductus ad vesperum est a patribus conscriptis, populo Romano, sociis et Latinis, pridie quam excessit e vita, ut ex tam alto dignitatis gradu ad superos videatur deos potius quam ad inferos pervenisse.</p>\', \'page\'),
                    (2, 2, \'Quae amicitia voluntatibus aut sententia acceperit est aequo neque affluentior.\', \'article\')',
                    
                    'INSERT INTO `field_description` (`field_id`, `content_id`, `content_description`, `content_type_name`) VALUES
                    (3, 3, \'<p>Le tiroir, facile &agrave; ouvrir et &agrave; fermer, est &eacute;quip&eacute; d&#39;un arr&ecirc;t.</p><p>Dimensions : 46 x&nbsp;35 cm</p>\', \'product\'),
                    (3, 4, \'<p>Zones de contact couvertes de cuir fleur souple teint&eacute; dans la masse de 1,2 mm d&#39;&eacute;paisseur tr&egrave;s moelleux et doux au toucher.</p>\', \'product\'),
                    (3, 5, \'<p>Le miroir est dot&eacute; d&#39;une pellicule anti-&eacute;clats au dos, ce qui r&eacute;duit le risque de blessure si le verre se brise.</p>\', \'product\'),
                    (3, 6, \'<p>Teint&eacute; brun fr&ecirc;ne teint&eacute; plaqu&eacute; fr&ecirc;ne.</p><p>La t&ecirc;te de lit souple est tr&egrave;s confortable ; vous pouvez vous y appuyer pour lire ou regarder la t&eacute;l&eacute;vision.</p>\', \'product\'),
                    (3, 7, \'<p>L&#39;ouverture &agrave; l&#39;arri&egrave;re vous permet de rassembler et d&#39;organiser facilement les c&acirc;bles.</p>\', \'product\'),
                    (3, 8, \'<p>Induction domino/booster</p><p>Garantie 5 ans gratuite. D&eacute;tails des conditions disponibles en magasin ou sur internet.</p>\', \'product\'),
                    (3, 9, \'<p>Garantie 10 ans gratuite. D&eacute;tails des conditions disponibles en magasin ou sur internet.</p>\', \'product\'),
					(3, 10, \'Novitates autem si spem adferunt, ut tamquam in herbis non fallacibus fructus appareat\', \'slider\'),
					(3, 11, \'Maxima est enim vis vetustatis et consuetudinis\', \'slider\')',
                    
                    'INSERT INTO `field_price` (`field_id`, `content_id`, `content_price`, `content_type_name`) VALUES
                    (5, 3, \'49.50\', \'product\'),
                    (5, 4, \'1549.00\', \'product\'),
                    (5, 5, \'35.00\', \'product\'),
                    (5, 6, \'379.50\', \'product\'),
                    (5, 7, \'55.00\', \'product\'),
                    (5, 8, \'259.50\', \'product\'),
                    (5, 9, \'69.50\', \'product\')',
                    
                    'INSERT INTO `field_stock` (`field_id`, `content_id`, `content_stock`, `content_type_name`) VALUES
                    (9, 3, \'64\', \'product\'),
                    (9, 4, \'7\', \'product\'),
                    (9, 5, \'21\', \'product\'),
                    (9, 6, \'40\', \'product\'),
                    (9, 7, \'35\', \'product\'),
                    (9, 8, \'8\', \'product\'),
                    (9, 9, \'14\', \'product\')',
                    
                    'INSERT INTO `field_category` (`field_id`, `content_id`, `content_category`, `content_type_name`) VALUES
                    (4, 3, \'1\', \'product\'),
                    (4, 4, \'3\', \'product\'),
                    (4, 5, \'2\', \'product\'),
                    (4, 6, \'1\', \'product\'),
                    (4, 7, \'3\', \'product\'),
                    (4, 8, \'4\', \'product\'),
                    (4, 9, \'2\', \'product\')',

                    'INSERT INTO `field_active` (`field_id`, `content_id`, `content_active`, `content_type_name`) VALUES
                    (11, 3, 1, \'product\'),
                    (11, 4, 1, \'product\'),
                    (11, 5, 1, \'product\'),
                    (11, 6, 1, \'product\'),
                    (11, 7, 1, \'product\'),
                    (11, 8, 1, \'product\'),
                    (11, 9, 1, \'product\')',

                    
                    'INSERT INTO `field_image` (`field_id`, `content_id`, `content_image`, `content_type_name`) VALUES
                    (10, 3, \'public/img/Content/ccda356949069d138e83dfbe402b893b.JPG\', \'product\'),
                    (10, 4, \'public/img/Content/94f6443c3ad607c078c0473ecbc8b71e.JPG\', \'product\'),
                    (10, 5, \'public/img/Content/7ac5319ae2499d6c19c6dd53f750371b.JPG\', \'product\'),
                    (10, 6, \'public/img/Content/5b74f7c77ca9b6b05774dd1e13518dba.JPG\', \'product\'),
                    (10, 7, \'public/img/Content/c82228a4392fb245fb70c39a9b9d2098.JPG\', \'product\'),
                    (10, 8, \'public/img/Content/964e024cbbefe76949d0b93ee41ac301.JPG\', \'product\'),
                    (10, 9, \'public/img/Content/42fb4c9cbc8de6ab19be9415a92bffdb.JPG\', \'product\')',

                    'INSERT INTO `field_title` (`field_id`, `content_id`, `content_title`, `content_type_name`) VALUES
                    (1, 1, \'Présentation\', \'page\'),
                    (1, 2, \'Nouvelle !\', \'article\'),
                    (1, 3, \'HEMNES - Table de chevet, brun noir\', \'product\'),
                    (1, 4, \'TIMSFORS - Canapé d&#39;angle 2+2 places\', \'product\'),
                    (1, 5, \'LILLÅNGEN - Miroir, blanc\', \'product\'),
                    (1, 6, \'OPPLAND - Cadre de lit\', \'product\'),
                    (1, 7, \'LACK - Banc TV, motif bouleau\', \'product\'),
                    (1, 8, \'MÖJLIG - Table cuisson induction\', \'product\'),
                    (1, 9, \'LILLÅNGEN - Lavabo, blanc\', \'product\'),
					(1, 10,\'Vente de produits\',\'slider\'),
					(1, 11,\'Produits divers\',\'slider\')',
                    
                    'INSERT INTO `field_caption` (`id`,`field_id`,`content_id`,`content_caption`,`content_type_name`) VALUES 
					(1,6,10,\'Novitates autem si appareat\',\'slider\'),
					(2,6,11,\'Vetustatis et consuetudinis\',\'slider\')',
                    
                    'INSERT INTO `field_link` (`id`,`field_id`,`content_id`,`content_link`,`content_type_name`) VALUES 
					(1,8,10,\'product\',\'slider\'),
					(2,8,11,\'contact\',\'slider\')',
                    
                    'INSERT INTO `field_path` (`id`,`field_id`,`content_id`,`content_path`,`content_type_name`) VALUES
					(1,7,10,\'public/img/Slider/62d9f3ef122254e8b5e8ed7d1ad3d10e.jpg\',\'slider\'),
					(2,7,11,\'public/img/Slider/ec3c6e131746f3173161ea907c830201.jpg\',\'slider\')',
                    
                    'INSERT INTO role (`name`) VALUES
                    (\'root\'),
                    (\'administrateur\'),
                    (\'inscrit\')',
                    
                    'INSERT INTO `tag` (`name`) VALUES
                    (\'Lit\'),
                    (\'Table de chevet\'),
                    (\'Miroir\'),
                    (\'Lavabo\'),
                    (\'Canapé\'),
                    (\'Meuble Télé\'),
                    (\'Placard\'),
                    (\'Plan de travail\')',

                );
                foreach($tables as $table) {
                    $create_table = $db->prepare($table);
                    $create_table->execute();
                }

                $ini = fopen("config/config.ini", "a+");
                $config .= "[db]\r\n";
                $config .= "dsn = \"mysql:dbname=".$dbname.";host=".$host.";charset=utf8\"\r\n";
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