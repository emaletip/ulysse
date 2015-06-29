<?php 

namespace app\models;

class User {

	private $pdo;

	private $id;
	private $email;
	private $password;
	private $last_name;
	private $first_name;
	private $address1;
	private $address2;
	private $postal_code;
	private $city;
	private $country;
	private $path;
	private $created_date;
	
	public function __construct() {
		$this->pdo = new \config\database();
	}
	
	public function getPdo() {
		return $this->pdo;	
	}
	
	public function connectUser($email, $password) {
		$password = sha1($password);
		
        $datas = [':email' => $email, ':password' => $password ];
		$dbuser = $this->pdo->query('SELECT * FROM user WHERE password=:password AND email=:email', $datas);
		$user = current($dbuser);
		return $user;
	}

	public function listUser() {
		$users = $this->pdo->query('SELECT u.*, ur.role_id FROM user AS u INNER JOIN user_role AS ur ON u.id = ur.user_id ORDER BY ur.role_id ASC');
		return $users;
	}

	public function getUser($id) {
		$user = $this->pdo->query('SELECT u.*, ur.role_id FROM user AS u INNER JOIN user_role AS ur ON u.id = ur.user_id WHERE u.id = ' . $id);
		return $user;
	}

	public function addUser(array $data) {
		// Ajout des données de la table USER
		$data['password'] = sha1($data['password']);
		$result = $this->pdo->insert(
			'INSERT INTO user (email, login, password, last_name, first_name, address1, address2, postal_code, city, country)
			VALUES (:email, :login, :password, :last_name, :first_name, :address1, :address2, :postal_code, :city, :country)',
			array(	
				':email' => $data['email'],
				':login' => $data['login'],
				':password' => $data['password'],
				':last_name' => $data['last_name'],
				':first_name' => $data['first_name'],
				':address1' => $data['address1'],
				':address2' => $data['address2'],
				':postal_code' => $data['postal_code'],
				':city' => $data['city'],
				':country' => $data['country']
			)
		);

		// Ajout des données de la table USER_ROLE pour définbir le role de l'utilisateur
		$lastId = $this->pdo->lastId();
		$result2 = $this->pdo->insert(
			'INSERT INTO user_role (user_id, role_id)
			VALUES (:user_id, :role_id)',
			array(
				':user_id' => $lastId,
				':role_id' => 3
			)
		);

		if($result && $result2) {
			return true;
		} else {
			return false;
		}
	}

	public function updateUser(array $data) {
		$req = 'UPDATE user SET ';

		foreach ($data as $k => $v) {
			if ($v != '') {
				if($k == 'password') {
					$v = sha1($v);
				}
				$reqtemp[] = $k."= :".$k;
				$datas[':'.$k] = $v;
			} else {
				unset($data[$k]);
			}
		}

		$req .= implode(', ', $reqtemp);
		$req .= ' WHERE id = :id';

		$result = $this->pdo->update(
			$req,
			$datas
		);
	}

	public function deleteUser($id) {
		$result = $this->pdo->delete('user', $id);
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	
	public function getEmail() {
		return $this->email;
	}
	
	public function setEmail($email) {
		$this->email = $email;
		return $this;
	}
	
	public function getPassword() {
		return $this->password;
	}
	
	public function setPassword($password) {
		$this->password = $password;
		return $this;
	}
	
	public function getLast_name() {
		return $this->last_name;
	}
	
	public function setLast_name($last_name) {
		$this->last_name = $last_name;
		return $this;
	}
	
	public function getFirst_name() {
		return $this->first_name;
	}
	
	public function setFirst_name($first_name) {
		$this->first_name = $first_name;
		return $this;
	}
	
	public function getAddress1() {
		return $this->address1;
	}
	
	public function setAddress1($address1) {
		$this->address1 = $address1;
		return $this;
	}
	
	public function getAddress2() {
		return $this->address2;
	}
	
	public function setAddress2($address2) {
		$this->address2 = $address2;
		return $this;
	}
	
	public function getPostal_code() {
		return $this->postal_code;
	}
	
	public function setPostal_code($postal_code) {
		$this->postal_code = $postal_code;
		return $this;
	}
	
	public function getCity() {
		return $this->city;
	}
	
	public function setCity($city) {
		$this->city = $city;
		return $this;
	}
	
	public function getCountry() {
		return $this->country;
	}
	
	public function setCountry($country) {
		$this->country = $country;
		return $this;
	}
	
	public function getPath() {
		return $this->path;
	}
	
	public function setPath($path) {
		$this->path = $path;
		return $this;
	}
	
	public function getCreated_date() {
		return $this->created_date;
	}
	
	public function setCreated_date($created_date) {
		$this->created_date = $created_date;
		return $this;
	}
      
}	
