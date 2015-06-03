<?php

$fichier_ini = @fopen("config/config.ini", "r");
if($fichier_ini != FALSE) {
    $ini_array = parse_ini_file("config/config.ini");
}

if ($fichier_ini == FALSE) {
	require_once('installation.php');
}
else if ($ini_array['install'] == 0) {
    require_once('configuration.php');
}
else {
    
    define("PS", PATH_SEPARATOR);
    define("PROJECT_PATH",    $ini_array['projectpath']);
    define("ROOT_PATH",	 	  $_SERVER['DOCUMENT_ROOT']."/".PROJECT_PATH);

    require_once(ROOT_PATH.'/config/database.php');
    $db = new database();
    
    print_r("SAY LE SIT WEEEEEE");
}