<?php

namespace config\Router;

class Route
{
    private $uri;
    private $method;
    private $action;
    private $allowedMethods = ['GET', 'POST', 'PUT', 'DELETE'];

    public function __construct($method, $uri, callable $action)
    {
        $this->setMethod($method)
             ->setUri($uri)
             ->setAction($action);
    }

    public function getUri()
    {
        return $this->uri;
    }
	
    public function getMethod()
    {
        return $this->method;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function setUri($uri)
    {
        $this->uri = (string) $uri;
        return $this;
    }
    
    public function setMethod($method)
    {
        $method = strtoupper($method);
        $this->method = (string) $method;
        return $this;
    }

    public function setAction(callable $action)
    {
        $this->action = $action;
        return $this;
    }


}