<?php

namespace app\controllers;

class controllertest {

private $test = 'test';

	public function setMaquette($test) {
		$this->test = $test;
		return $this;
	}

	public function getMaquette() {
		return $this->test;
	}
	
	public function postAdd() {
		var_dump($_POST);
		die;
	}
	
}