<?php

namespace config\Router;

class Response
{
    private $headers = array();
    private $body;
    
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function addHeader($key, $value)
    {
        $this->headers[$key] = (string) $value;
        return $this;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function redirect($location)
    {
        $this->addHeader('Location', $location);
        $this->output();
    }

    public function output()
    {
    	foreach ($this->getHeaders() as $key => $value) {
	    	if($key == 'Content-Type'){
	    		continue;
	    	}
	        header(sprintf('%s: %s', $key, $value));
	    }
        return $this->getBody();
    }
}
