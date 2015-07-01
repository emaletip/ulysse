<?php
$routes = array();

/*************/
/*   FRONT   */
/*************/



/************/
/*   BACK   */
/************/

/* exemple route simple */

$routes['layout'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'get',
					  'controller' => 'Layout',
					  'action' => 'Layout',
					  'view' => 'maquette',
				   );	
				   				   
/* Block */		
				   	
$routes['dashboard/block'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'get',
					  'controller' => 'Block',
					  'action' => 'List',
					  'view' => 'list',
				   );
$routes['dashboard/block/([0-9]+)'] = array(
					  'path' => 'app',
					  'id' => true,
					  'type' => 'get',
					  'controller' => 'Block',
					  'action' => 'View',
					  'view' => 'view',
				   );
$routes['dashboard/block/edit/([0-9]+)'] = array(
					  'path' => 'app',
					  'id' => true,
					  'type' => 'get',
					  'controller' => 'Block',
					  'action' => 'Edit',
					  'view' => 'edit',
				   );

$routes['dashboard/block/update'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'post',
					  'controller' => 'Block',
					  'action' => 'Edit',
					  'view' => 'edit',
				   );

$routes['dashboard/emplacement'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'get',
					  'controller' => 'Block',
					  'action' => 'Emplacement',
					  'view' => 'place',
				   );
$routes['dashboard/emplacement/update'] = array(
					  'path' => 'app',
					  'id' => true,
					  'type' => 'post',
					  'controller' => 'Emplacement',
					  'action' => 'update',
					  'view' => 'edit',
				   );
				   
/* User */				   

$routes['dashboard/user/list'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'get',
					  'controller' => 'User',
					  'action' => 'User_list',
					  'view' => 'list',
				   );	
// Pauline
$routes['dashboard/user/add'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'get',
					  'controller' => 'User',
					  'action' => 'User_add',
					  'view' => 'add',
				   );
$routes['dashboard/user/insert'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'post',
					  'controller' => 'User',
					  'action' => 'User_add',
					  'view' => 'add',
				   ); 
$routes['dashboard/user/update'] = array(
					  'path' => 'app',
					  'id' => true,
					  'type' => 'post',
					  'controller' => 'User',
					  'action' => 'User_update',
					  'view' => 'edit',
				   );

/* Order */

$routes['dashboard/order'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'get',
					  'controller' => 'Order',
					  'action' => 'List',
					  'view' => 'list',
				   );

/* Config */

$routes['dashboard/config'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'get',
					  'controller' => 'Config',
					  'action' => 'Config',
					  'view' => 'edit',
				   );

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

$routes['dashboard/content/add'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'get',
					  'controller' => 'Content',
					  'action' => 'Product_add',
					  'view' => 'add',
				   );
$routes['dashboard/content/insert'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'post',
					  'controller' => 'Content',
					  'action' => 'Product_add',
					  'view' => 'add',
				   );

$routes['dashboard/content/add/article'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'get',
					  'controller' => 'Content',
					  'action' => 'Article_add',
					  'view' => 'addArticle',
				   );

$routes['dashboard/content/insert/article'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'post',
					  'controller' => 'Content',
					  'action' => 'Article_add',
					  'view' => 'addArticle',
				   );

$routes['dashboard/content/edit/([0-9]+)'] = array(
					  'path' => 'app',
					  'id' => true,
					  'type' => 'get',
					  'controller' => 'Content',
					  'action' => 'Product_edit',
					  'view' => 'edit',
				   );
$routes['dashboard/content/update'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'post',
					  'controller' => 'Content',
					  'action' => 'Product_edit',
					  'view' => 'edit',
				   );

$routes['dashboard/content/delete/([0-9]+)'] = array(
					  'path' => 'app',
					  'id' => true,
					  'type' => 'get',
					  'controller' => 'Content',
					  'action' => 'Product_delete',
					  'view' => 'delete',
				   );
$routes['dashboard/content/remove'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'post',
					  'controller' => 'Content',
					  'action' => 'Product_delete',
					  'view' => 'delete',
				   );

$routes['dashboard/user/([0-9]+)'] = array(
					  'path' => 'app',
					  'id' => true,
					  'type' => 'get',
					  'controller' => 'User',
					  'action' => 'User',
					  'view' => 'view',
				   );

// Pauline
$routes['dashboard/user/edit/([0-9]+)'] = array(
					  'path' => 'app',
					  'id' => true,
					  'type' => 'get',
					  'controller' => 'User',
					  'action' => 'User',
					  'view' => 'edit',
				   );
$routes['dashboard/user/delete/([0-9]+)'] = array(
					  'path' => 'app',
					  'id' => true,
					  'type' => 'get',
					  'controller' => 'User',
					  'action' => 'User_delete',
					  'view' => 'list',
				   );
// Fin Pauline	


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