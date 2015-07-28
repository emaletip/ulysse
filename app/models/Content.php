<?php 

namespace app\models;

class Content {

    private $pdo;
	private $id;
	private $created_date;
	private $content_type_name;
	private $created_user;

    public function __construct() {
        $this->pdo = new \config\database();
    }
    
    public function getFieldList() {
        return $this->pdo->query('SELECT * FROM field WHERE custom = 1'); 
    }
    public function getFieldAdd() {
    }
    public function postFieldDelete(){   
        
        $query = $this->pdo->query('SELECT name, type, id FROM field WHERE id = '.$_POST['id'].'');
        $this->pdo->update('DELETE FROM field WHERE id = '.$_POST['id'].'');
        $this->pdo->update('DELETE FROM content_field WHERE field_id = '.$_POST['id'].' AND content_type_id = 4');
        $this->pdo->query('DROP TABLE '.$query[0]->name);
        
        if($query[0]->type == 'select'){
            $this->pdo->update('DELETE FROM content_select WHERE field_name = \''.$query[0]->name.'\'');
        }
    }
    public function postFieldAdd() {
        
        if(!empty($_POST['label']) && !empty($_POST['name'])) {
            
            $insert = $this->pdo->insert(
            'INSERT INTO field (name, label, type, size_min, size_max, custom)
            VALUES (:name, :label, :type, :size_min, :size_max, :custom)', array(
                ':name' => 'field_'.$_POST['name'],
                ':label' => $_POST['label'],
                ':type' => $_POST['type'],
                ':size_min' => '0',
                ':size_max' => '100',
                ':custom' => '1'
                )
            );
            $lastId = $this->pdo->lastId();
            $insert = $this->pdo->insert(
            'INSERT INTO content_field (content_type_id, field_id)
            VALUES (:content_type_id, :field_id)', array(
                ':content_type_id' => '4',
                ':field_id' => $lastId
                )
            );
            $table = $this->pdo->query(
            'CREATE TABLE IF NOT EXISTS `field_'.$_POST['name'].'` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `field_id` int(11) NOT NULL,
                  `content_id` int(11) NOT NULL,
                  `content_'.$_POST['name'].'` varchar(255) NOT NULL,
                  `content_type_name` varchar(100) NOT NULL,
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1'
            );
            
            $list_id = $this->getProductList();
            foreach($list_id as $id) {
                $insert = $this->pdo->insert(
                'INSERT INTO field_'.$_POST['name'].' (field_id, content_id, content_'.$_POST['name'].', content_type_name)
                VALUES (:field_id, :content_id, :content_'.$_POST['name'].', :content_type_name)', array(
                    ':field_id' => $lastId,
                    ':content_id' => $id->content_id,
                    ':content_'.$_POST['name'].'' => '',
                    ':content_type_name' => 'product'
                    )
                );
            }
        
            if(!empty($_POST['contenuselect']) && $_POST['type'] == 'select'){
                $ligne = explode("\n", $_POST['contenuselect']);
                foreach($ligne as $val){
                    $insert = $this->pdo->insert(
                    'INSERT INTO content_select (name, field_name)
                    VALUES (:name, :field_name)', array(
                        ':name' => $val,
                        ':field_name' => 'field_'.$_POST['name']
                        )
                    );
                }
            }
            return true;
        }
        else {
            return false;
        }
    }
    public function getFieldEdit($id) {
        $results = $this->pdo->query('SELECT * FROM field WHERE id = '.$id.'');
        if($results[0]->type == 'select'){
            $content = $this->pdo->query('SELECT * FROM content_select WHERE field_name = \''.$results[0]->name.'\'');
            $results[] = $content;
        }
        return $results;
    }
    public function postFieldEdit() {
        
        if(!empty($_POST['label']) && !empty($_POST['name'])) {
            
            $query = $this->pdo->update(
            'UPDATE field SET label = :label WHERE id = :id', array(
                ':id' => $_POST['id'],
                ':label' => $_POST['label']
                )
            );
            
            if(!empty($_POST['contenuselect']) && $_POST['type'] == 'select'){
                $del = $this->pdo->update('DELETE FROM content_select WHERE field_name = \''.$_POST['name'].'\'');
                $ligne = explode("\n", $_POST['contenuselect']);
                foreach($ligne as $val){
                    $insert = $this->pdo->insert(
                    'INSERT INTO content_select (name, field_name)
                    VALUES (:name, :field_name)', array(
                        ':name' => $val,
                        ':field_name' => $_POST['name']
                        )
                    );
                }
            }
        }
    }
    
    public function getFields($id) {
        $content_type_id = $this->pdo->query('SELECT c.id, c.content_type_name, ct.name, ct.id AS content_type_id FROM content c
        LEFT JOIN content_type ct ON c.content_type_name = ct.name WHERE c.id = '.$id.'');
        $content_fields = $this->pdo->query('SELECT * FROM content_field WHERE content_type_id = '.$content_type_id[0]->content_type_id.'');
        foreach($content_fields as $id) {
            $fields[] = $this->pdo->query('SELECT * FROM field WHERE id = '.$id->field_id.'');
        }
        return($fields);
    }
    public function getFieldsName($name) {
        $content_type_id = $this->pdo->query('SELECT * FROM content_type WHERE name = \''.$name.'\'');
        $content_fields = $this->pdo->query('SELECT * FROM content_field WHERE content_type_id = '.$content_type_id[0]->id.'');
		$fields = array();
        foreach($content_fields as $id) {
            $fields[] = $this->pdo->query('SELECT * FROM field WHERE id = '.$id->field_id.'');
        }
        return($fields);
    }
    
    public function printField($type, $name, $value, $min = 0, $max = 255, $options = array()) {
        switch ($type) {
            case "input_file":
                return '<input type="file" name="'.$name.'" value="'.$value.'" min="'.$min.'" max="'.$max.'" class="form-control">';
            case "input_text":
                return '<input type="text" name="'.$name.'" value="'.$value.'" min="'.$min.'" max="'.$max.'" class="form-control">';
            case "input_decimal":
                return '<input type="number" name="'.$name.'" value="'.$value.'" class="form-control">';
             case "input_checkbox":
                return '<input type="checkbox" value="1" name="'.$name.'" '.($value == 1 ? 'checked' : '').' class="checkbox ">';    
            case "textarea":
                return '<textarea name="'.$name.'" class="form-control ckeditor" rows="3">'.$value.'</textarea>';
            case "select":
                $input = '<select name="'.$name.'" class="form-control">';
                if(!empty($options)) {
                    foreach($options as $val){
                        $input .= '<option value="'.$val->id.'" '.($val->id == $value ? 'selected' : '') .'>'.$val->name.'</option>';
                    }
                }
                $input .= '</select>';
                return($input);
        }   
    }
    
    public function getContentSelect($name){
        $query = 'SELECT * FROM content_select WHERE field_name = \''.$name.'\'';
        $results = $this->pdo->query($query);
        return $results;
    }
    public function getContentSelectValue($id){
        $query = 'SELECT * FROM content_select WHERE id = \''.$id.'\'';
        $results = $this->pdo->query($query);
        return $results; 
    }
    
    public function getProductList(){
        $query = 'SELECT c.*, ft.*, fp.*, fs.*, fc.*,fa.*,fi.*, cy.name AS category_name, u.login AS user_login, c.id AS content_id, t.*, t.id AS content_type_id FROM `content` c
        JOIN `content_type` t ON c.content_type_name = t.name
        JOIN `field_title` ft ON c.id = ft.content_id
        JOIN `field_price` fp ON c.id = fp.content_id
        JOIN `field_stock` fs ON c.id = fs.content_id
        JOIN `field_category` fc ON c.id = fc.content_id
        JOIN `field_active` fa ON c.id = fa.content_id
        JOIN `field_image` fi ON c.id = fi.content_id
        JOIN `category` cy ON cy.id = fc.content_category
        JOIN `user` u ON u.id = c.created_user
        WHERE c.`content_type_name` = \'product\'';
        $results = $this->pdo->query($query);
        return $results;
    }
    
    public function postProductListSearch(){
        $query = 'SELECT c.*, ft.*, fp.*, fs.*, fc.*,fa.*,fi.*, cy.name AS category_name, u.login AS user_login, c.id AS content_id, t.*, t.id AS content_type_id FROM `content` c
        JOIN `content_type` t ON c.content_type_name = t.name
        JOIN `field_title` ft ON c.id = ft.content_id
        JOIN `field_price` fp ON c.id = fp.content_id
        JOIN `field_stock` fs ON c.id = fs.content_id
        JOIN `field_category` fc ON c.id = fc.content_id
        JOIN `field_active` fa ON c.id = fa.content_id
        JOIN `field_image` fi ON c.id = fi.content_id
        JOIN `category` cy ON cy.id = fc.content_category
        JOIN `user` u ON u.id = c.created_user
        WHERE c.`content_type_name` = \'product\' AND ft.`content_title` LIKE \'%'.$_POST['name'].'%\'';
        $results = $this->pdo->query($query);
        return $results;
    }
    
     public function getSliderList(){
        $query = 'SELECT c.*, ft.*, fi.*, fd.*, fc.*, fl.*, c.id AS content_id, t.*, t.id AS content_type_id FROM `content` c
        JOIN `content_type` t ON c.content_type_name = t.name
        JOIN `field_title` ft ON c.id = ft.content_id
        JOIN `field_path` fi ON c.id = fi.content_id
        JOIN `field_description` fd ON c.id = fd.content_id
        JOIN `field_link` fl ON c.id = fl.content_id
        JOIN `field_caption` fc ON c.id = fc.content_id
        WHERE c.`content_type_name` = \'slider\'';
        $results = $this->pdo->query($query);
        return $results;
    }
    
    public function getArticleList(){
        $query = 'SELECT c.*, ft.*, fb.*, u.login, u.last_name, u.first_name, c.id AS content_id, t.*, t.id AS content_type_id FROM `content` c
        JOIN `content_type` t ON c.content_type_name = t.name
        JOIN `field_title` ft ON c.id = ft.content_id
        JOIN `field_body` fb ON c.id = fb.content_id
        JOIN `user` u ON c.created_user = u.id
        WHERE c.`content_type_name` = \'article\'';
        $results = $this->pdo->query($query);
        return $results;
    }
    
    public function getPageList(){
        $query = 'SELECT c.*, ft.*, fb.*, c.id AS content_id, t.*, t.id AS content_type_id FROM `content` c
        JOIN `content_type` t ON c.content_type_name = t.name
        JOIN `field_title` ft ON c.id = ft.content_id
        JOIN `field_body` fb ON c.id = fb.content_id
        WHERE c.`content_type_name` = \'page\'';
        $results = $this->pdo->query($query);
        return $results;
    }
    
    
    public function getProduct($id){
        $fields = $this->getFields($id);
        $results['fields'] = $fields;
        $query = 'SELECT *, c.id AS content_id, t.id AS content_type_id, cy.name AS category_name FROM `content` c
        JOIN `content_type` t ON c.content_type_name = t.name ';
        foreach($fields as $key => $field){
            $query .= 'JOIN `'.$field[0]->name.'` f'.$key.' ON c.id = f'.$key.'.content_id ';
        }
        $query .= 'JOIN `category` cy ON cy.id = f2.content_category ';
        $query .= 'WHERE c.`content_type_name` = \'product\' AND c.id = '.$id.'';
        $results['results'] = $this->pdo->query($query);
        return($results);
    }
    
    public function getUserProduct($id){
    	
		$query = 'SELECT id FROM `content` c WHERE `created_user`='.$id.' AND c.`content_type_name` = \'product\'';
		$results = $this->pdo->query($query);
		$products = array();
        if(!empty($results)) {
	        foreach($results as $res_p) {
		        $products[] = $this->getProduct($res_p->id);
	        }
        }
        $query2 = 'SELECT content_id FROM `user_content` WHERE `user_id`='.$id;
		$results2 = $this->pdo->query($query2);
		if(!empty($results2)) {
	        foreach($results2 as $res_p2) {
		        $products_plus[] = $this->getProduct($res_p2->content_id);
	        }
			foreach($products_plus as $k => $pp) {
				var_dump($k);
				$p = current($pp['results']);
				$p->content_price;
			}
			die;
        }
        return $products;  
    
	}
    
	public function getPage($id){
        $query = 'SELECT c.*, ft.*, fb.*, c.id AS content_id, t.*, t.id AS content_type_id FROM `content` c
        JOIN `content_type` t ON c.content_type_name = t.name
        JOIN `field_title` ft ON c.id = ft.content_id
        JOIN `field_body` fb ON c.id = fb.content_id
        WHERE c.`content_type_name` = \'page\'  AND c.id = '.$id.'';
        $results = $this->pdo->query($query);
        return $results;  
    }

    public function getArticle($id){
        $query = 'SELECT c.*, ft.*, fb.*, fi.*, u.login, u.last_name, u.first_name, c.id AS content_id, t.*, t.id AS content_type_id FROM `content` c
        JOIN `content_type` t ON c.content_type_name = t.name
        JOIN `field_title` ft ON c.id = ft.content_id
        JOIN `field_body` fb ON c.id = fb.content_id
        LEFT JOIN `field_image` fi ON c.id = fi.content_id
        JOIN `user` u ON c.created_user = u.id
        WHERE c.`content_type_name` = \'article\'  AND c.id = '.$id.'';
        $results = $this->pdo->query($query);

        $query2 = 'SELECT ct.*, t.* FROM `content_tag` ct
        JOIN `tags` t ON ct.tag_id = t.id
        WHERE ct.content_id = '.$id.'';
        $results2 = $this->pdo->query($query2);

        if ($results2 != null) {
            foreach ($results2 as $v) {
                $tagtemp[] = $v->name;
                $tagtemp2[] = '<a href="/'.PROJECT_DIRECTORY.'tag/'.$v->tag_id.'">'.$v->name.'</a>';
            }
            $string = implode(',', $tagtemp);
            $string2 = implode(',', $tagtemp2);

            $results[0]->tags = $string;
            $results[0]->tagsView = $string2;
        }

        return $results;  
    }

	public function getSlider($id){
        $query = 'SELECT c.*, ft.*, fi.*, fd.*, fc.*, fl.*, c.id AS content_id, t.*, t.id AS content_type_id FROM `content` c
        JOIN `content_type` t ON c.content_type_name = t.name
        JOIN `field_title` ft ON c.id = ft.content_id
        JOIN `field_path` fi ON c.id = fi.content_id
        JOIN `field_description` fd ON c.id = fd.content_id
        JOIN `field_link` fl ON c.id = fl.content_id
        JOIN `field_caption` fc ON c.id = fc.content_id
        WHERE c.`content_type_name` = \'slider\'
        AND c.id='.$id;
        $results = $this->pdo->query($query);
        return $results;
    }
    
	public function addUserProduct($data){

	    $query_content = $this->pdo->insert(
        'INSERT INTO user_content (user_id, content_id, content_price)
        VALUES (:user_id, :content_id, :content_price)', array(
            ':user_id' => $_SESSION['user']->id,
            ':content_id' => (int)$data['id_product'],
            ':content_price' => $data['price'],
            )
        );
        return $query_content;
	}
					  
					  
    public function addProduct(array $data) {
			
		$query_content = $this->pdo->insert(
        'INSERT INTO content (content_type_name, created_date, created_user)
        VALUES (:content_type_name, :created_date, :created_user)', array(
            ':content_type_name' => 'product',
            ':created_date' => date('Y-m-d H:i:s'),
            ':created_user' => $_SESSION['user']->id
            )
        );
        
        $lastId = $this->pdo->lastId();
        
        foreach($data as $key => $value) {	
	          switch ($key) {
	        	case 'title':
	        		$field_id = 1;
	        		break;
	        	case 'body':
	        		$field_id = 2;
	        		break;
	        	case 'description':
	        		$field_id = 3;
	        		break;
				case 'category':
	        		$field_id = 4;
	        		break;
				case 'price':
	        		$field_id = 5;
	        		break;
				case 'caption':
	        		$field_id = 6;
	        		break;
				case 'path':
	        		$field_id = 7;
	        		break;
				case 'link':
	        		$field_id = 8;
	        		break;
                case 'image':
                    $field_id = 10;
                    break;
                case 'active':
                    $field_id = 11;
                    break;
				default: 
	        		$field_id = 1;
	        		break;
			}

            $query = $this->pdo->insert(
            'INSERT INTO field_'.$key.' (field_id, content_id, content_'.$key.', content_type_name)
            VALUES (:field_id, :content_id, :content_'.$key.', :content_type_name)', array(
                ':field_id' => $field_id,
                ':content_id' => $lastId,
                ':content_'.$key.'' => $value,
                ':content_type_name' => 'product'
                )
            );
            if($query){
                $error = 0;
            } else {
                $error = 1;
            }
        }
		if($error == 0) {
			return true;
		} else {
			return false;
		}
	}
    
    public function addContent(array $data, $type) {
        
		$query_content = $this->pdo->insert(
        'INSERT INTO content (content_type_name, created_date, created_user)
        VALUES (:content_type_name, :created_date, :created_user)', array(
            ':content_type_name' => $type,
            ':created_date' => date('Y-m-d H:i:s'),
            ':created_user' => $_SESSION['user']->id
            )
        );
        
		$lastId = $this->pdo->lastId();

        foreach($data as $key => $value) {
        	
        	switch ($key) {
	        	case 'title':
	        		$field_id = 1;
	        		break;
	        	case 'body':
	        		$field_id = 2;
	        		break;
                case 'image':
                    $field_id = 10;
                    break;
	        	default: 
	        		$field_id = 1;
	        		break;
        	}
            $query = $this->pdo->insert(
            'INSERT INTO field_'.$key.' (field_id, content_id, content_'.$key.', content_type_name)
            VALUES (:field_id, :content_id, :content_'.$key.', :content_type_name)', array(
                ':field_id' => $field_id,
                ':content_id' => $lastId,
                ':content_'.$key.'' => $value,
                ':content_type_name' => $type
                )
            );
            if($query){
                $error = 0;
            } else {
                $error = 1;
            }
        }

        if ($type == 'article') {
            $error = $this->addTags($data, $lastId);
        }

		if($error == 0) {
			return true;
		} else {
			return false;
		}
	}
	
	 public function addSlider(array $data) {
                
		$query_content = $this->pdo->insert(
        'INSERT INTO content (content_type_name, created_date, created_user)
        VALUES (:content_type_name, :created_date, :created_user)', array(
            ':content_type_name' => 'slider',
            ':created_date' => date('Y-m-d H:i:s'),
            ':created_user' => $_SESSION['user']->id
            )
        );
        
		$lastId = $this->pdo->lastId();

        foreach($data as $key => $value) {
        	
        	switch ($key) {
	        	case 'title':
	        		$field_id = 1;
	        		break;
                case 'description':
	        		$field_id = 3;
	        		break;
				case 'caption':
	        		$field_id = 6;
	        		break;
				case 'link':
	        		$field_id = 8;
	        		break;
                case 'image':
                    $field_id = 10;
                    break;
	        	default: 
	        		$field_id = 1;
	        		break;
        	}
            $query = $this->pdo->insert(
            'INSERT INTO field_'.$key.' (field_id, content_id, content_'.$key.', content_type_name)
            VALUES (:field_id, :content_id, :content_'.$key.', :content_type_name)', array(
                ':field_id' => $field_id,
                ':content_id' => $lastId,
                ':content_'.$key.'' => $value,
                ':content_type_name' => 'slider'
                )
            );

            if($query){
                $error = 0;
            } else {
                $error = 1;
            }
        }

		if($error == 0) {
			return true;
		} else {
			return false;
		}
	}	

	public function editContent(array $data) {
        
		foreach($data as $key => $value) {
            if($key != 'content_id'){
                $query = $this->pdo->update(
                'UPDATE field_'.$key.' SET content_'.$key.' = :content_'.$key.' WHERE content_id = :content_id', array(
                    ':content_id' => $data['content_id'],
                    ':content_'.$key.'' => $value
                    )
                );
                if($query){
                    $error = 0;
                } else {
                    $error = 1;
                }
            }
        }
            
		if($error == 0) {
			return true;
		} else {
			return false;
		}
	}
    
    public function deleteProduct($id) {
        
        $product = $this->getProduct($id);        
        
       	foreach ($product['fields'] as $field){
       		$query2 = $this->pdo->update(
	        'DELETE FROM '.($field[0]->name).' WHERE content_id = :id', array(
	            ':id' => $id
	            )
	        );
	         if($query2){
                $error = 0;
            } else {
                $error = 1;
            }
       	}       
        
        $query = $this->pdo->update(
        'DELETE FROM content WHERE id = :id', array(
            ':id' => $id
            )
        );
            
		if($error == 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function deletePage($id) {
       
        $query = $this->pdo->update(
        'DELETE FROM content WHERE id = :id', array(
            ':id' => $id
            )
        );
        
        $query2 = $this->pdo->update(
        'DELETE FROM field_title WHERE content_id = :id', array(
            ':id' => $id
            )
        );

		$query3 = $this->pdo->update(
        
        'DELETE FROM field_body WHERE content_id = :id', array(
            ':id' => $id
            )
        );
        
        if($error == 0) {
            return true;
        } else {
            return false;
        }

    }
    
    public function deleteSlider($id) {
       
        $query = $this->pdo->update(
        'DELETE FROM content WHERE id = :id', array(
            ':id' => $id
            )
        );
        
        $data = ['field_title','field_path','field_description','field_link','field_caption'];
		foreach($data as $key) {
            if($key != 'content_id'){
                $query = $this->pdo->update(
                'DELETE FROM '.$key.' WHERE content_id=:content_id', array(
                    ':content_id' => $id
                    )
                );
                if($query){
                    $error = 0;
                } else {
                    $error = 1;
                }
            }
        }

		if($error == 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function updateSlider($data) { 
		$id = (int) $data['id'];    
		unset($data['id']);

		foreach($data as $key=> $val) {
			$tb = str_replace('content', 'field', $key);
			$valname = ':'.$key;
            if($key != 'content_id'){
                $query = $this->pdo->update(
                'UPDATE '.$tb.' SET '.$key.'=:'.$key.' WHERE content_id=:content_id', array(
                    ':content_id' => $id,
                    $valname => $val
                    )
                );
                if($query){
                    $error = 0;
                } else {
                    $error = 1;
                }
            }
        }
		if($error == 0) {
			return true;
		} else {
			return false;
		}
	}
    
    public function getCategory($id){
        $query = 'SELECT * FROM category WHERE id = '.$id.'';
        
        $results = $this->pdo->query($query);
        
        /* get products from the current category */
		$query = 'SELECT c.*, ft.*, fp.*, fs.*, fc.*,fa.*, cy.name AS category_name, u.login AS user_login, c.id AS content_id, t.*, t.id AS content_type_id FROM `content` c
        JOIN `content_type` t ON c.content_type_name = t.name
        JOIN `field_title` ft ON c.id = ft.content_id
        JOIN `field_price` fp ON c.id = fp.content_id
        JOIN `field_stock` fs ON c.id = fs.content_id
        JOIN `field_category` fc ON c.id = fc.content_id
        JOIN `field_active` fa ON c.id = fa.content_id
        JOIN `category` cy ON cy.id = fc.content_category
        JOIN `user` u ON u.id = c.created_user
        WHERE c.`content_type_name` = \'product\'
        AND fc.id='.$id;
        $res = $this->pdo->query($query);

        $results[0]->products = $res;
        
        return $results;
    }

    /*      ARTICLES       */

    public function editArticle(array $data) {

        // Récupération des éventuels noms de champs qui nous seront nécessaire pour la mise à jour
        $keys[] = 'title';
        $keys[] = 'body';
        if (array_key_exists('image', $data)) {
            $keys[] = 'image';

            // Recherche si une image était déjà relié à ce contenu
            $image_query = $this->pdo->query(
                'SELECT * FROM field_image
                WHERE content_id = :content_id', array(
                    ':content_id' => $data['id']
                )
            );

            // Si le contenu ne possédait pas d'image à la base, alors on lui ajoute celle qui a été ajouté dans le formulaire
            if (!$image_query) {
                $image_insert = $this->pdo->insert(
                    'INSERT INTO field_image (field_id, content_id, content_image, content_type_name)
                    VALUES (10, :content_id, :content_image, "article")', array(
                        ':content_id' => $data['id'],
                        ':content_image' => $data['image']
                    )
                );
            }
        }

        // Pour chacun de ces champs ...
        foreach ($keys as $v) {

            // ... la table de ce champs (image, titre, body, ...) est mise à jour
            $query = $this->pdo->update(
                'UPDATE field_' . $v . ' SET content_' . $v . ' = :content_' . $v . ' WHERE content_id = :content_id', array(
                    ':content_id' => $data['id'],
                    ':content_' . $v . '' => $data[$v]
                )
            );

            if($query){
                $error = 0;
            } else {
                $error = 1;
            }

        }

        $error = $this->addTags($data, $data['id']);
            
        if($error == 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getContentsByTag($tag_id) {
        $query = $this->pdo->query(
            'SELECT * FROM field_title AS ft
            JOIN content_tag AS ct ON ft.content_id = ct.content_id
            JOIN tags AS t ON ct.tag_id = t.id
            WHERE ct.tag_id = :tag_id', array(
                ':tag_id' => $tag_id
            )
        );

        foreach ($query as $k => $q) {
            if ($q->content_type_name == 'product') {
                $r = $this->pdo->query('SELECT content_description FROM field_description WHERE content_id = :content_id', array(':content_id' => $q->content_id));
                $query[$k]->description = $r[0]->content_description;
            } else {
                $r = $this->pdo->query('SELECT content_body FROM field_body WHERE content_id = :content_id', array(':content_id' => $q->content_id));
                $query[$k]->body = $r[0]->content_body;
            }
        }

        if($query) {
            return $query;
        } else {
            return false;
        }
    }

    public function addTags(array $data, $id) {

        /* Liste des tags inscrit dans le formulaire : $tags */
        // Récupération des données du formulaire
        $string_tags = str_replace(' ', '', strtolower($data['tag']));
        $tags = explode(',', $string_tags);

        /* Liste complète des tags : $selected_tags */
        // Requête
        $st = $this->pdo->query(
            'SELECT * FROM tags'
        );

        // Rangement au propre dans un tableau
        $selected_tags = array();
        foreach ($st as $t) {
            $selected_tags[$t->id] = $t->name;
        }

        /* Liste complète des tags relié au contenu $id : $tags_content */
        // Requête
        $t_c = $this->pdo->query(
            'SELECT * FROM tags AS t
            JOIN content_tag AS ct ON t.id = ct.tag_id
            WHERE ct.content_id = :content_id', array(
                ':content_id' => $id
            )
        );

        // Rangement au propre dans un tableau
        $tags_content = array();
        foreach ($t_c as $tc) {
            $tags_content[$tc->id] = $tc->name;
        }
        

        /* Gestion au cas ou l'un des tags souhaite être supprimer */
        // Pour chaque tags relié au contenu ...
        foreach ($tags_content as $key => $val) {

            // Si le tags relié au contenu ne fait pas partit des tags envoyé par le formulaire ...
            if (!in_array($val, $tags)) {

                // ... alors on supprime sa liaison avec le contenu
                $delete_query = $this->pdo->delete('content_tag', $key);
            }

        }

        /* Gestion des ajout à effectuer dans la base de données */
        // Par chaque tag récupéré dans le champs du formulaire : 
        // 1 : Si le tag n'est pas enregistré dans la table "tags", il est alors ajouté à cette table et relié au contenu dans la table "content_tag"
        // 2 : Sinon, une vérification est faite pour savoir si le tag n'est pas déjà relié au contenu. Si ce n'est pas le cas, il est relié dans la table "content_table"

        foreach ($tags as $v) {

            // CF 1
            if (!in_array($v, $selected_tags)) {

                // ... L'ajouter à la base.
                $query = $this->pdo->insert(
                    'INSERT INTO tags (name)
                    VALUES (:name)', array(
                        ':name' => $v
                    )
                );

                // Récupérer l'id du précédent ajout
                $last_tag_id = $this->pdo->lastId();

                // Relier le nouveau tag ajouté au contenu actuel
                $query2 = $this->pdo->insert(
                    'INSERT INTO content_tag (content_id, tag_id)
                    VALUES (:content_id, :tag_id)', array(
                        ':content_id' => $id,
                        ':tag_id' => $last_tag_id
                    )
                );

                if ($query && $query2) {
                    $error = 1;
                } else {
                    $error = 0;
                }

            // CF 2
            } else {

                // Rechercher l'id du tag à ajouter déjà existant en base ...
                $tag_id = array_search($v, $selected_tags);

                // Selectionner toutes les éventuelles liaisons entre le contenu et le tag
                $content_tags = $this->pdo->query(
                    'SELECT * FROM content_tag 
                    WHERE content_id = :content_id 
                    AND tag_id = :tag_id', array(
                        ':content_id' => $id,
                        ':tag_id' => $tag_id
                    )
                );

                // S'il n'existe pas de liaison entre le contenu et le tag concerné ...
                if(empty($content_tags)) {

                    // ... créer cette liaison
                    $query = $this->pdo->insert(
                        'INSERT INTO content_tag (content_id, tag_id)
                        VALUES (:content_id, :tag_id)', array(
                            ':content_id' => $id,
                            ':tag_id' => $tag_id
                        )
                    );

                    if ($query) {
                        $error = 1;
                    } else {
                        $error = 0;
                    }

                }

            }

        }

        return $error;
    }

    public function deleteArticle($id) {

        // Suppression du contenu dans la table regroupant tous les contenus        
        $query = $this->pdo->update(
        'DELETE FROM content WHERE id = :id', array(
            ':id' => $id
            )
        );

        // Suppression des liaisons entre ce contenu et les tags
        $query = $this->pdo->update(
            'DELETE FROM content_id WHERE content_id = :content_id', array(
                ':content_id' => $id
            )
        );

        // Récupération des éventuels noms de champs qui nous seront nécessaire pour la suppression
        $keys[] = 'title';
        $keys[] = 'body';
        $keys[] = 'image';

        // Pour chacun de ces champs ...
        foreach ($keys as $v) {

            // ... la table de ce champs (image, titre, body, ...) est mise à jour
            $query = $this->pdo->update(
                'DELETE FROM field_'.$v.' WHERE content_id = :content_id', array(
                ':content_id' => $id
                )
            );

            if($query){
                $error = 0;
            } else {
                $error = 1;
            }

        }
            
        if($error == 0) {
            return true;
        } else {
            return false;
        }

    }
    
    public function postContact(){
        $mail = 'tonytetrel@gmail.com';
        if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) {
            $passage_ligne = "\r\n";
        } else {
            $passage_ligne = "\n";
        }
        
        $message_txt = $_POST['message'];
        $message_html = $_POST['message'];
        
        $boundary = "-----=".md5(rand());
        
        $sujet = $_POST['object'];
        
        $header = "From: <".$_POST['email'].">".$passage_ligne;
        $header.= "Reply-to: <".$_POST['email'].">".$passage_ligne;
        $header.= "MIME-Version: 1.0".$passage_ligne;
        $header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
        
        $message = $passage_ligne."--".$boundary.$passage_ligne;
        
        $message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$passage_ligne;
        $message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
        $message.= $passage_ligne.$message_txt.$passage_ligne;
        
        $message.= $passage_ligne."--".$boundary.$passage_ligne;
        
        $message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;
        $message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
        $message.= $passage_ligne.$message_html.$passage_ligne;
        
        $message.= $passage_ligne."--".$boundary."--".$passage_ligne;
        $message.= $passage_ligne."--".$boundary."--".$passage_ligne;
        
        $res = mail($mail, $sujet, $message, $header);
        return 1;
    }
	
	/*      FIN ARTICLES       */   

    public function AllCategory(){
        $query = 'SELECT * FROM category';
        $results = $this->pdo->query($query);
        return $results;
    }
	
	public function getPdo() {
		return $this->pdo;	
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	
	public function getCreated_date() {
		return $this->created_date;
	}
	
	public function setCreated_date($created_date) {
		$this->created_date = $created_date;
		return $this;
	}
	
	public function getContent_type_name() {
		return $this->content_type_name;
	}
	
	public function setContent_type_name($content_type_name) {
		$this->content_type_name = $content_type_name;
		return $this;
	}
	 
}	
