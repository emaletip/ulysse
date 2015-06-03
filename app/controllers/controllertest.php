<?php

namespace app\controllers;

class controllertest {

private $test = 'test';

	public function setTest($test) {
		$this->test = $test;
		return $this;
	}

	public function getTest() {
		return $this->test;
	}
	
	public function postAdd() {
		var_dump($_POST);
		die;
	}
	
}