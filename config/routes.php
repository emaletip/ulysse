<?php
$routes = array();

/* exemple route simple */

$routes['layout'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'get',
					  'controller' => 'Layout',
					  'action' => 'Layout',
					  'view' => 'maquette',
				   );	
$routes['dashboard/config'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'get',
					  'controller' => 'Config',
					  'action' => 'Config',
					  'view' => 'edit',
				   );	
$routes['dashboard/block'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'get',
					  'controller' => 'Block',
					  'action' => 'List',
					  'view' => 'list',
				   );	
$routes['dashboard/user/list'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'get',
					  'controller' => 'User',
					  'action' => 'User_list',
					  'view' => 'list',
				   );	
// Pauline
/*$routes['dashboard/user/add'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'get',
					  'controller' => 'User',
					  'action' => 'User_form',
					  'view' => 'edit',
				   );
$routes['dashboard/user/add'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'post',
					  'controller' => 'User',
					  'action' => 'User_add',
					  'view' => 'edit',
				   );*/   
// Fin Pauline

$routes['dashboard/config/update'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'post',
					  'controller' => 'Config',
					  'action' => 'Config_update',
					  'view' => 'edit',
				   );

$routes['dashboard/content'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'get',
					  'controller' => 'Content',
					  'action' => 'ProductList',
					  'view' => 'list',
				   );			   
				   
$routes['dashboard/content/([0-9]+)'] = array(
					  'path' => 'app',
					  'id' => true,
					  'type' => 'get',
					  'controller' => 'Content',
					  'action' => 'Product',
					  'view' => 'view',
				   );	
$routes['dashboard/user/([0-9]+)'] = array(
					  'path' => 'app',
					  'id' => true,
					  'type' => 'get',
					  'controller' => 'User',
					  'action' => 'User',
					  'view' => 'view',
				   );
$routes['dashboard/user/edit/([0-9]+)'] = array(
					  'path' => 'app',
					  'id' => true,
					  'type' => 'get',
					  'controller' => 'User',
					  'action' => 'User',
					  'view' => 'edit',
				   );		

/* exemple route post			   
$routes['add'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'post',
					  'controller' => 'controllertest',
					  'action' => 'Add',
					  'view' => 'list',
				   );


				   	
/* exemple route avec ID 	   	

$routes['test/([0-9]+)'] = array(
						  'path' => 'app',
						  'id' => true,
						  'type' => 'get',
						  'controller' => 'controllertest',
						  'action' => 'Test',
						  'view' => 'list',
					   );	

*/