<?php 
$ini_array = parse_ini_file("config.ini");
 
define("PS", PATH_SEPARATOR);
define('DS', DIRECTORY_SEPARATOR);
define("PROJECT_DIRECTORY",    $ini_array['projectpath'].'/');
define("ROUTE_PATH",    '/'.PROJECT_DIRECTORY);

define('HTTP_PATH', 'http://'.$_SERVER['HTTP_HOST'] . ROUTE_PATH);

define('ROOT_PATH', __DIR__ . DS);
define('PUBLIC_PATH', ROOT_PATH  . 'public' . DS);
define('FRONT_VIEWS_PATH', ROOT_PATH . '../app/views/' );
define('FRONT_CSS_PATH', HTTP_PATH . '../app/css/' );
define('FRONT_IMG_PATH', HTTP_PATH . '../app/img/' );
define('FRONT_JS_PATH', HTTP_PATH . '../app/js/' );

set_include_path(implode( PATH_SEPARATOR, array(FRONT_VIEWS_PATH, ROOT_PATH, PUBLIC_PATH, FRONT_CSS_PATH, FRONT_IMG_PATH, FRONT_JS_PATH)));

function myLoader($file){
    require_once str_replace('\\',DS,$file) . '.php' ;
}

spl_autoload_register('myLoader'); 

require_once(ROOT_PATH.'/router/Api.php');
require_once(ROOT_PATH.'/database.php');

$api = new config\Router\Api();
$api->serve();

$db = new database();

if (!array_search('config', array_column($db->pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_ASSOC), 'Tables_in_'.$ini_array['dbname']))) {
	require_once(ROOT_PATH.'/init.php');
}

