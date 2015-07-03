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
/* Produits */

$routes['dashboard/product'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'get',
					  'controller' => 'Content',
					  'action' => 'ProductList',
					  'view' => 'list',	
					);

$routes['dashboard/product/([0-9]+)'] = array(
					  'path' => 'app',
					  'id' => true,
					  'type' => 'get',
					  'controller' => 'Content',
					  'action' => 'Product',
					  'view' => 'view',
				   );

$routes['dashboard/product/add'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'get',
					  'controller' => 'Content',
					  'action' => 'Product_add',
					  'view' => 'add',
				   );
$routes['dashboard/product/insert'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'post',
					  'controller' => 'Content',
					  'action' => 'Product_add',
					  'view' => 'add',
				   );

$routes['dashboard/product/edit/([0-9]+)'] = array(
					  'path' => 'app',
					  'id' => true,
					  'type' => 'get',
					  'controller' => 'Content',
					  'action' => 'Product_edit',
					  'view' => 'edit',
				   );
$routes['dashboard/product/update'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'post',
					  'controller' => 'Content',
					  'action' => 'Product_edit',
					  'view' => 'edit',
				   );

$routes['dashboard/product/delete/([0-9]+)'] = array(
					  'path' => 'app',
					  'id' => true,
					  'type' => 'get',
					  'controller' => 'Content',
					  'action' => 'Product_delete',
					  'view' => 'delete',
				   );
$routes['dashboard/product/remove'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'post',
					  'controller' => 'Content',
					  'action' => 'Product_delete',
					  'view' => 'delete',
				   );

/* Fields */

$routes['dashboard/fields'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'get',
					  'controller' => 'Content',
					  'action' => 'FieldList',
					  'view' => 'listField',	
					);
$routes['dashboard/fields/add'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'get',
					  'controller' => 'Content',
					  'action' => 'FieldAdd',
					  'view' => 'addField',	
					);
$routes['dashboard/fields/insert'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'post',
					  'controller' => 'Content',
					  'action' => 'FieldAdd',
					  'view' => 'addField',	
					);

/* pages */

$routes['dashboard/page'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'get',
					  'controller' => 'Content',
					  'action' => 'PageList',
					  'view' => 'listPage',
				   );			   
				   
$routes['dashboard/page/([0-9]+)'] = array(
					  'path' => 'app',
					  'id' => true,
					  'type' => 'get',
					  'controller' => 'Content',
					  'action' => 'Page',
					  'view' => 'viewPage',
				   );

$routes['dashboard/page/add'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'get',
					  'controller' => 'Content',
					  'action' => 'Page_add',
					  'view' => 'addPage',
				   );
$routes['dashboard/page/insert'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'post',
					  'controller' => 'Content',
					  'action' => 'Page_add',
					  'view' => 'addPage',
				   );

$routes['dashboard/page/edit/([0-9]+)'] = array(
					  'path' => 'app',
					  'id' => true,
					  'type' => 'get',
					  'controller' => 'Content',
					  'action' => 'Page_edit',
					  'view' => 'editPage',
				   );
$routes['dashboard/page/update'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'post',
					  'controller' => 'Content',
					  'action' => 'Page_edit',
					  'view' => 'editPage',
				   );

/* articles */

$routes['dashboard/article'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'get',
					  'controller' => 'Content',
					  'action' => 'ArticleList',
					  'view' => 'listArticle',
				   );			   
				   
$routes['dashboard/article/([0-9]+)'] = array(
					  'path' => 'app',
					  'id' => true,
					  'type' => 'get',
					  'controller' => 'Content',
					  'action' => 'Article',
					  'view' => 'viewArticle',
				   );

$routes['dashboard/article/add'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'get',
					  'controller' => 'Content',
					  'action' => 'Article_add',
					  'view' => 'addArticle',
				   );
$routes['dashboard/article/insert'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'post',
					  'controller' => 'Content',
					  'action' => 'Article_add',
					  'view' => 'addArticle',
				   );

$routes['dashboard/article/edit/([0-9]+)'] = array(
					  'path' => 'app',
					  'id' => true,
					  'type' => 'get',
					  'controller' => 'Content',
					  'action' => 'Article_edit',
					  'view' => 'editArticle',
				   );
$routes['dashboard/article/update'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'post',
					  'controller' => 'Content',
					  'action' => 'Article_edit',
					  'view' => 'editArticle',
				   );
$routes['dashboard/article/delete/([0-9]+)'] = array(
					  'path' => 'app',
					  'id' => true,
					  'type' => 'get',
					  'controller' => 'Content',
					  'action' => 'Article_delete',
					  'view' => 'listArticle',
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