<?php 
$fichier_ini = @fopen("config/config.ini", "r");
$base_directory = str_replace('index.php','',$_SERVER['PHP_SELF']);

if($fichier_ini != FALSE) {
    $ini_array = parse_ini_file("config/config.ini");
}
if ($fichier_ini == FALSE) {
    if($base_directory != $_SERVER['REQUEST_URI']) {
		header('Location: http://'.$_SERVER["HTTP_HOST"].$base_directory);
	}
	require_once('installation.php');
} else if ($ini_array['install'] == 0) {
    if($base_directory != $_SERVER['REQUEST_URI']) {
		header('Location: http://'.$_SERVER["HTTP_HOST"].$base_directory);
	}
	require_once('configuration.php');
} else {
    
	define("PS", PATH_SEPARATOR);
	define('DS', DIRECTORY_SEPARATOR);
	define("PROJECT_DIRECTORY",    $ini_array['projectpath']. '/');
	define("ROUTE_PATH",    '/'.PROJECT_DIRECTORY );
	
	define('HTTP_PATH', 'http://'.$_SERVER['HTTP_HOST'] . ROUTE_PATH);
	
	define('ROOT_PATH', __DIR__ . DS);
	define('PUBLIC_PATH', HTTP_PATH . 'public/'); //Pauline
	define('VENDOR_PATH', HTTP_PATH .'vendor/'); //Pauline

	define('FRONT_VIEWS_PATH', ROOT_PATH . '../app/views/' );
	define('FRONT_CSS_PATH', PUBLIC_PATH . 'css/' );
	define('FRONT_IMG_PATH', PUBLIC_PATH . 'img/' );
	define('FRONT_JS_PATH', PUBLIC_PATH . 'js/' );
	
	define('BACK_VIEWS_PATH', ROOT_PATH . '../app/views/admin/' );
	define('BACK_CSS_PATH', PUBLIC_PATH . 'admin/css/' ); // Pauline (accès aux fichiers publiques d'admin)
	define('BACK_IMG_PATH', PUBLIC_PATH . 'admin/img/' ); // Pauline (accès aux fichiers publiques d'admin)
	define('BACK_JS_PATH', PUBLIC_PATH . 'admin/js/' ); // Pauline (accès aux fichiers publiques d'admin)

	require_once('functions.php');
	
	set_include_path(implode( PATH_SEPARATOR, array(FRONT_VIEWS_PATH, ROOT_PATH, PUBLIC_PATH, FRONT_CSS_PATH, FRONT_IMG_PATH, FRONT_JS_PATH,BACK_VIEWS_PATH,BACK_CSS_PATH,BACK_IMG_PATH,BACK_JS_PATH)));
	
	function myLoader($file){
	    require_once str_replace('\\',DS,$file) . '.php' ;
	}
	spl_autoload_register('myLoader');

	session_start();

	require_once(ROOT_PATH.'/router/Api.php');
    require_once(ROOT_PATH.'/database.php');
    
    $db = new config\database();
    
	$api = new config\Router\Api();
	$api->serve();

}