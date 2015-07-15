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
                    ':content_type_name' => 'produit'
                    )
                );
            }
        
            if(!empty($_POST['contenuselect']) && $_POST['type'] == 'select'){
                $ligne = explode("\n", $_POST['contenuselect']);
                foreach($ligne as $l){
                   $tab[] = explode("|", $l); 
                }
            }

            die();
            return true;
        }
        else {
            return false;
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
        foreach($content_fields as $id) {
            $fields[] = $this->pdo->query('SELECT * FROM field WHERE id = '.$id->field_id.'');
        }
        return($fields);
    }
    
    public function printField($type, $name, $value, $min = 0, $max = 255) {
        switch ($type) {
            case "input_text":
                return '<input type="text" name="'.$name.'" value="'.$value.'" min="'.$min.'" max="'.$max.'" class="form-control">';
            case "input_decimal":
                return '<input type="number" name="'.$name.'" value="'.$value.'" class="form-control">';
            case "textarea":
                return '<textarea name="'.$name.'" class="form-control" rows="3">'.$value.'</textarea>';
            case "select":
                $input = '<select name="'.$name.'" class="form-control">';
                foreach($value as $val){
                    $input .= '<option value="'.$val->id.'">'.$val->name.'</option>';
                }
                $input .= '</select>';
                return($input);
        }   
    }
    
    public function getProductList(){
        $query = 'SELECT c.*, ft.*, fp.*, fs.*, fc.*, c.id AS content_id, t.*, t.id AS content_type_id FROM `content` c
        JOIN `content_type` t ON c.content_type_name = t.name
        JOIN `field_title` ft ON c.id = ft.content_id
        JOIN `field_price` fp ON c.id = fp.content_id
        JOIN `field_stock` fs ON c.id = fs.content_id
        JOIN `field_category` fc ON c.id = fc.content_id
        WHERE c.`content_type_name` = \'product\'';
        $results = $this->pdo->query($query);
        return $results;
    }
    
    public function getArticleList(){
        $query = 'SELECT c.*, ft.*, fb.*, u.login, c.id AS content_id, t.*, t.id AS content_type_id FROM `content` c
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
        $query = 'SELECT *, c.id AS content_id, t.id AS content_type_id FROM `content` c
        JOIN `content_type` t ON c.content_type_name = t.name ';
        foreach($fields as $key => $field){
            $query .= 'JOIN `'.$field[0]->name.'` f'.$key.' ON c.id = f'.$key.'.content_id ';
        }
        $query .= 'WHERE c.`content_type_name` = \'product\' AND c.id = '.$id.'';
        $results['results'] = $this->pdo->query($query);
        return($results);
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
        $query = 'SELECT c.*, ft.*, fb.*, fi.*, u.login, c.id AS content_id, t.*, t.id AS content_type_id FROM `content` c
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
            }
            $string = implode(',', $tagtemp);

            $results[0]->tags = $string;
        }

        return $results;  
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
            var_dump($query.'<br>');
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
    
    public function deleteProduct(array $data) {
        
        $query = $this->pdo->update(
        'DELETE FROM content WHERE id = :id', array(
            ':id' => $data['content_id']
            )
        );
        
		foreach($data as $key => $value) {
            if($key != 'content_id'){
                $query = $this->pdo->update(
                'DELETE FROM field_'.$key.' WHERE content_id = :content_id', array(
                    ':content_id' => $data['content_id']
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
        return $results;
    }

    /*      ARTICLES       */

    public function editArticle(array $data) {

        $keys[] = 'title';
        $keys[] = 'body';
        if (array_key_exists('image', $data)) {
            $keys[] = 'image';
        }

        foreach ($keys as $v) {

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

    public function addTags(array $data, $id) {

        // Afin d'être sûr en attendant une autre solution plus efficace ...
        // Nottamment si l'utilisateur n'efface qu'un seul des tags déjà présent !
        $delete_query = $this->pdo->deleteWithColumn('content_tag', 'content_id', $id);

        // Tentative désespérée de sélectionner les tags déjà reliés au contenu
        /*$tags_content = $this->pdo->query(
            'SELECT * FROM tags AS t
            JOIN content_tag AS ct ON t.id = ct.tag_id
            WHERE ct.content_id = :content_id', array(
                ':content_id' => $id
            )
        );

        $tc = array();

        foreach ($tags_content as $t_c) {
            $tc[$t_c->id] = $t_c->name;
        }*/

        // Enlever tous les espaces de la chaine
        $string_tags = str_replace(' ', '', $data['tag']);

        // Récupération de la chaine de tag du formulaire pour en faire un tableau
        $tags = explode(',', $string_tags);

        // Sélectionne tous les tags existants dans la base de données
        $st = $this->pdo->query(
            'SELECT * FROM tags'
        );

        // Placer l'id des tags de la base en guise d'identifiant
        $selected_tags = array();

        foreach ($st as $t) {
            $selected_tags[$t->id] = $t->name;
        }

        // Pour chaque tag, l'ajouter à la table
        foreach ($tags as $v) {

            // Tentative désespérée de supprimer le tag de la base de donnée si le tag en court ne fait pas partit de la liste $tc
            /*if (!in_array($v, $tc)) {
                $delete_query = $this->pdo->deleteWithColumn('content_id', array(
                    'content_id' => $id,
                    'tag_id' => array_search($v, $selected_tags)
                ));
            }*/

            // Si le tag n'est pas dans la liste des tags déjà présent dans la base ...
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

                // S'il n'existe pas de liaison entre le contenu et le tag concerné
                if(empty($content_tags)) {

                    // ... Créer cette liaison
                    $query = $this->pdo->insert(
                        'INSERT INTO content_tag (content_id, tag_id)
                        VALUES (:content_id, :tag_id)', array(
                            ':content_id' => $id,
                            ':tag_id' => $tag_id
                        )
                    );
                }

                if ($query) {
                    $error = 1;
                } else {
                    $error = 0;
                }

            }

        }

        return $error;
    }

    public function deleteArticle(array $data) {
        
        $query = $this->pdo->update(
        'DELETE FROM content WHERE id = :id', array(
            ':id' => $data['content_id']
            )
        );
        
        foreach($data as $key => $value) {
            if($key != 'content_id'){
                $query = $this->pdo->update(
                'DELETE FROM field_'.$key.' WHERE content_id = :content_id', array(
                    ':content_id' => $data['content_id']
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
