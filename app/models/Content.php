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
                    $input .= '<option value="'.$val.'">'.$val.'</option>';
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
        $query = 'SELECT c.*, ft.*, fb.*, c.id AS content_id, t.*, t.id AS content_type_id FROM `content` c
        JOIN `content_type` t ON c.content_type_name = t.name
        JOIN `field_title` ft ON c.id = ft.content_id
        JOIN `field_body` fb ON c.id = fb.content_id
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
        $query = 'SELECT c.*, ft.*, fb.*, c.id AS content_id, t.*, t.id AS content_type_id FROM `content` c
        JOIN `content_type` t ON c.content_type_name = t.name
        JOIN `field_title` ft ON c.id = ft.content_id
        JOIN `field_body` fb ON c.id = fb.content_id
        WHERE c.`content_type_name` = \'article\'  AND c.id = '.$id.'';
        $results = $this->pdo->query($query);
        return $results;  
    }

    public function addProduct(array $data) {
        
		$query_content = $this->pdo->insert(
        'INSERT INTO content (content_type_name, created_date, created_user)
        VALUES (:content_type_name, :created_date, :created_user)', array(
            ':content_type_name' => 'product',
            ':created_date' => date('Y-m-d H:i:s'),
            ':created_user' => '1'
            )
        );
        
		$lastId = $this->pdo->lastId();
        
        foreach($data as $key => $value) {
            $query = $this->pdo->insert(
            'INSERT INTO field_'.$key.' (field_id, content_id, content_title, content_type_name)
            VALUES (:field_id, :content_id, :content_'.$key.', :content_type_name)', array(
                ':field_id' => '1',
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
