<?php
$routes = array();

/* exemple route simple */

$routes['test'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'get',
					  'controller' => 'Test',
					  'action' => 'Test',
					  'view' => 'list',
				   );

$routes['layout'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'get',
					  'controller' => 'Layout',
					  'action' => 'Layout',
					  'view' => 'maquette',
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