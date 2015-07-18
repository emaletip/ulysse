<?php

namespace config\Router\Result;

use config\Router\Result;

class Result404 extends Result
{
    /**
     * @var int 
     */
    public $code = 404;

    /**
     * @var boolean 
     */
    public $error = true;
    
    public $data;
    
    public function __construct() {		
		$this->data = '';
	}
	
	public function redirect404() {
		include_once('404.phtml');	
	}
    
    
}
