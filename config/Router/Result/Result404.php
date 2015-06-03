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
         $this->data = @file_get_contents(FRONT_VIEWS_PATH . '404.phtml');
	}
    
    
}
