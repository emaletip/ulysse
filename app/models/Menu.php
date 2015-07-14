<?php 

namespace app\models;

class Menu {

	private $id;
	private $label;
	private $pdo; 
	
	public function __construct() {
		$this->pdo = new \config\database();
	}
	
	public function getItem_by_type($type) {
		
		switch ($type) {
			case 'link':
				$array = array();
				break;
				
			case 'category':
				$i = 1;
				$categoryModel = new \app\models\Category();
				$categorys = $categoryModel->getList();
				foreach ($categorys as $category) {
						$array[$i]['title'] = $category->name;
						$array[$i]['id'] = $category->id;
						$array[$i]['type'] = 'Catégorie';
						$array[$i]['table'] = 'category';
					$i ++;
				}
				break;
				
			case 'page':
				$i = 1;
				$contentModel = new \app\models\Content();
				$contents = $contentModel->getPageList();
				foreach ($contents as $content) {
					$array[$i]['title'] = $content->content_title;
					$array[$i]['id'] = $content->content_id;
					$array[$i]['type'] = 'Page';
					$array[$i]['table'] = 'content';
					$i ++;
				}
				break;
		}
		
		echo json_encode($array);
		die;
	}
	
	public function getAdd_item($post) {
	
		foreach($post as $k => $v) {
			$sqlnames[] = $k;
			$sqldatas[] = ':'.$k;
			$datas[':'.$k] = $v;
		}
		
		$sql ='INSERT INTO `content_menu` (' . implode(', ',$sqlnames) . ') VALUES (' . implode(', ',$sqldatas).');';

		$dbuser = $this->getPdo()->insert($sql, $datas);				

		return $dbuser;
	}
		
	public function getUpdate_item($post) {
		$sql ='UPDATE content_menu SET ';
		foreach($post as $k => $v) {
			$sqldatas[] = $k.'=:'.$k;
			$datas[':'.$k] = $v;
		}
	
		$sql .= implode(', ',$sqldatas);
		$sql .= ' WHERE id=:id';
		return $this->getPdo()->update($sql, $datas);
	}

	public function getAdd($data) {

		// Ajout des données de la table USER

		$result = $this->pdo->insert(
			'INSERT INTO menu (label)
			VALUES (:label)',
			array(	
				':label' => $data['label'],
			)
		);

		// Ajout des données de la table USER_ROLE pour définbir le role de l'utilisateur
		$lastId = $this->pdo->lastId();
		
		$result2 = $this->pdo->insert(
			'INSERT INTO content_menu (menu_id, content_id)
			VALUES (:menu_id, :content_id)',
			array(
				':menu_id' => $lastId,
				':content_id' => $data['content_id']
			)
		);

		if($result && $result2) {
			return true;
		} else {
			return false;
		}
	}
	
	public function getPdo() {
		return $this->pdo;	
	}
	
	public function getList() {
		return $this->pdo->query('SELECT * FROM menu;');
	}
	
	public function getItem($table, $id) {

		if ($table == 'page') {
			$table = 'content';
		}
	
		$sql = 'SELECT * FROM '.$table;
		if ($table == 'content') {
			$sql .= ' JOIN field_title ON field_title.content_id=content.id ';
		}	
		$sql .= ' WHERE content.id='.$id;
		
		return $this->pdo->query($sql);
	}
	
	/*
public function RecursiveWrite($array) {
	    
	    foreach ($array as $vals) {
			$ar[$vals->id]['item'] = $vals->id;
			
			if ($vals->parent_id != NULL){
				
				$ar[$vals->parent_id]['children'] = $this->RecursiveWrite($vals);	
				$ar[$vals->id]['is_child'] = 1;
			}  
			
			
	    }
	    return $ar;
	}
*/
			
	public function	getMenu($id) {	
		$parents = $this->pdo->query('SELECT * FROM content_menu WHERE menu_id='.$id.' AND parent_id IS NULL ORDER BY position ASC;');
		$order = array();
		
		
		if(!empty($parents)) {
			foreach($parents as $parent) {
				$order[$parent->id]['item'] = $parent;
				$children = $this->pdo->query('SELECT * FROM content_menu WHERE parent_id='.$parent->id.' ORDER BY position ASC');
				
				foreach($children as $child) { 
					$order[$parent->id]['children'][$child->id]['item'] = $child;
					$children2 = $this->pdo->query('SELECT * FROM content_menu WHERE parent_id='.$child->id.' ORDER BY position ASC');
					
					foreach($children2 as $child2) {
					$order[$parent->id]['children'][$child->id]['children'][$child2->id]['item'] = $child2;
					}
				} 
			}
		}
		return $order;
	}
	
 	public function getId() {
		return $this->id;
	}
	
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	
 	public function getLabel() {
		return $this->label;
	}
	
	public function setLabel($label) {
		$this->label = $label;
		return $this;
	}

}	
