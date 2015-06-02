<?php 
$ini_array = parse_ini_file("config.ini");

define("PS", PATH_SEPARATOR);
define("PROJECT_PATH",    $ini_array['projectpath']);
define("ROOT_PATH",	 	  $_SERVER['DOCUMENT_ROOT']."/".PROJECT_PATH);

require_once(ROOT_PATH.'/config/database.php');

$db = new database();

if (!array_search('config', array_column($db->pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_ASSOC), 'Tables_in_'.$ini_array['dbname']))) {
	require_once(ROOT_PATH.'/config/init.php');
}

