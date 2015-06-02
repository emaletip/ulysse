<?php 
echo 'configuration<br>';

define("PROJECT_PATH",    "/ulysse");
define("ROOT_PATH","/".$_SERVER['DOCUMENT_ROOT'].PROJECT_PATH);

require_once(ROOT_PATH.'/config/database.php');

$db = new database();

if (!array_search('config', array_column($db->pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_ASSOC), 'Tables_in_'.database::DATABASE))) {
	require_once(ROOT_PATH.'/config/init.php');
}

