<?php

namespace config\Router;

class Router
{
    private $request;
    private $routes;

    public function __construct(array $routes = array(), Request $request = null)
    {
        if (empty($routes)) {
            $this->clearRoutes();
        }
        $this->addRoutes($routes);

        if (null !== $request) {
            $this->setRequest($request);
        }
    }

    public function clearRoutes()
    {
        $this->routes = array();
        return $this;
    }
    
    public function addRoute(Route $route)
    {
        $this->routes[$route->getUri()] = $route;
        return $this;
    }

    public function addRoutes(array $routes)
    {
        foreach ($routes as $route) {
            $this->addRoute($route);
        }
    }

    public function getRoutes()
    {
        return $this->routes;
    }

    public function setRequest(Request $request)
    {
        $this->request = $request;
        return $this;
    }

    public function getRequest()
    {
        if ($this->request === null) {
            $this->request = new Request();
        }
        return $this->request;
    }

    public function run()
    {
        $matches = array();
        $request = $this->getRequest();
        $uri     = $request->getUri();

        foreach ($this->getRoutes() as $route) {
            $pattern = '#^'.$route->getUri().'$#';
            if (preg_match($pattern, $uri, $matches) && 
                $route->getMethod() === $request->getMethod()) {
                array_shift($matches);
                $matches['route'] = $route->getUri();
                $this->getRequest()->setParams($matches);
                return $route;
            }
        }
        return false;
    }
}

