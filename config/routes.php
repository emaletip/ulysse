<?php
$routes = array();

/*************/
/*   FRONT   */
/*************/

$routes['register'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'get',
					  'controller' => 'User',
					  'action' => 'User_add',
					  'view' => 'frontadd',
				   );
$routes['order'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'get',
					  'controller' => 'Cart',
					  'action' => 'Step1',
					  'view' => 'viewStep1',
				   );

$routes['register/insert'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'post',
					  'controller' => 'User',
					  'action' => 'User_add',
					  'view' => 'add',
				   ); 	

$routes['product'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'get',
					  'controller' => 'Content',
					  'action' => 'ProductList',
					  'view' => 'frontlistProduct',
				   );

$routes['product/([0-9]+)'] = array(
					  'path' => 'app',
					  'id' => true,
					  'type' => 'get',
					  'controller' => 'Content',
					  'action' => 'Product',
					  'view' => 'frontviewProduct',
				   );

$routes['user/([0-9]+)'] = array(
					  'path' => 'app',
					  'id' => true,
					  'type' => 'get',
					  'controller' => 'User',
					  'action' => 'User',
					  'view' => 'frontview',
				   );

$routes['product/add'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'get',
					  'controller' => 'Content',
					  'action' => 'Product_add',
					  'view' => 'frontaddProduct',
				   );
$routes['product/insert'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'post',
					  'controller' => 'Content',
					  'action' => 'Product_add',
					  'view' => 'frontaddProduct',
				   );

$routes['cart/add/([0-9]+)'] = array(
					  'path' => 'app',
					  'id' => true,
					  'type' => 'get',
					  'controller' => 'Cart',
					  'action' => 'AddProduct',
					  'view' => 'frontlistArticle',
				   );

$routes['cart/delete/([0-9]+)'] = array(
					  'path' => 'app',
					  'id' => true,
					  'type' => 'post',
					  'controller' => 'Cart',
					  'action' => 'DeleteProduct',
					  'view' => 'frontlistArticle',
				   );
// Pauline
$routes['article'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'get',
					  'controller' => 'Content',
					  'action' => 'ArticleList',
					  'view' => 'frontlistArticle',
				   );

$routes['tag/([0-9]+)'] = array(
					  'path' => 'app',
					  'id' => true,
					  'type' => 'get',
					  'controller' => 'Content',
					  'action' => 'ContentByTagList',
					  'view' => 'frontlistByTag',
				   );
// Fin Pauline			   
$routes['page/([0-9]+)'] = array(
					  'path' => 'app',
					  'id' => true,
					  'type' => 'get',
					  'controller' => 'Content',
					  'action' => 'Page',
					  'view' => 'frontviewPage',
				   );

$routes['category/([0-9]+)'] = array(
					  'path' => 'app',
					  'id' => true,
					  'type' => 'get',
					  'controller' => 'Content',
					  'action' => 'Category',
					  'view' => 'frontviewCategory',
				   );
				   
$routes['article/([0-9]+)'] = array(
					  'path' => 'app',
					  'id' => true,
					  'type' => 'get',
					  'controller' => 'Content',
					  'action' => 'Article',
					  'view' => 'frontviewArticle',
				   );
				   				   
$routes['contact'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'get',
					  'controller' => 'Content',
					  'action' => 'Contact',
					  'view' => 'frontviewContact',
				   );
				   
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
				   				   
/*	Slider	*/

$routes['dashboard/slider'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'get',
					  'controller' => 'Block',
					  'action' => 'Slider_list',
					  'view' => 'listSlider',
				   );
$routes['dashboard/slider/([0-9]+)'] = array(
					  'path' => 'app',
					  'id' => true,
					  'type' => 'get',
					  'controller' => 'Block',
					  'action' => 'Slider_view',
					  'view' => 'viewSlider',
				   );
$routes['dashboard/slider/edit/([0-9]+)'] = array(
					  'path' => 'app',
					  'id' => true,
					  'type' => 'get',
					  'controller' => 'Block',
					  'action' => 'Slider_edit',
					  'view' => 'editSlider',
				   );

$routes['dashboard/slider/update'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'post',
					  'controller' => 'Block',
					  'action' => 'Slider_edit',
					  'view' => 'editSlider',
				   );	
$routes['dashboard/slider/add'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'get',
					  'controller' => 'Block',
					  'action' => 'Slider_add',
					  'view' => 'addSlider',
				   );
$routes['dashboard/slider/insert'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'post',
					  'controller' => 'Block',
					  'action' => 'Slider_add',
					  'view' => 'addSlider',
				   ); 
$routes['dashboard/slider/update'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'post',
					  'controller' => 'Block',
					  'action' => 'Slider_update',
					  'view' => 'addSlider',
				   ); 
$routes['dashboard/slider/edit/([0-9]+)'] = array(
					  'path' => 'app',
					  'id' => true,
					  'type' => 'get',
					  'controller' => 'Block',
					  'action' => 'Slider_edit',
					  'view' => 'editSlider',
				   );
$routes['dashboard/slider/delete/([0-9]+)'] = array(
					  'path' => 'app',
					  'id' => true,
					  'type' => 'get',
					  'controller' => 'Block',
					  'action' => 'Slider_delete',
					  'view' => 'list',
				   );
/*	Block	*/		
				   	
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
$routes['dashboard/user/edit/([0-9]+)'] = array(
					  'path' => 'app',
					  'id' => true,
					  'type' => 'get',
					  'controller' => 'User',
					  'action' => 'User_edit',
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
/* Menu */

$routes['dashboard/menu'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'get',
					  'controller' => 'Menu',
					  'action' => 'List',
					  'view' => 'list',
				   );

$routes['dashboard/menu/delete/([0-9]+)'] = array(
					  'path' => 'app',
					  'id' => true,
					  'type' => 'get',
					  'controller' => 'Menu',
					  'action' => 'Delete',
					  'view' => 'list',
				   );
				   
$routes['dashboard/menu/add'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'get',
					  'controller' => 'Menu',
					  'action' => 'Add',
					  'view' => 'add',
				   );
				   
$routes['dashboard/menu/update'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'post',
					  'controller' => 'Menu',
					  'action' => 'Update',
					  'view' => 'edit',
				   );				  				   
				   			   
$routes['dashboard/menu/insert'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'post',
					  'controller' => 'Menu',
					  'action' => 'Add',
					  'view' => 'add',
				   );

$routes['dashboard/menu/type'] = array(
					  'path' => 'app',
					  'id' => false,
					  'type' => 'post',
					  'controller' => 'Menu',
					  'action' => 'Type',
					  'view' => 'add',
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
$routes['dashboard/page/delete/([0-9]+)'] = array(
					  'path' => 'app',
					  'id' => true,
					  'type' => 'get',
					  'controller' => 'Content',
					  'action' => 'Page_delete',
					  'view' => 'listPage',
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
