<?php

namespace config\Router;

use config\Router\Request;
use config\Router\Response;
use config\Router\Route;
use config\Router\Router;
use config\Router\Result\Result404;
use app\controllers\User;

class Api {

	private $request;
	private $router;
	private $response;
	
	/**
	* Project routes.
	*/
	public function __construct() {
		
		$this->setResponse(new Response())
		->setRouter(new Router())
		->setRequest($this->getRouter()->getRequest());

		if(!isset($_SESSION['user'])) {
			require_once BACK_VIEWS_PATH . 'login.phtml';
		}

		$this->get(ROUTE_PATH . 'dashboard/login', function () {
			if(isset($_SESSION['user'])) {
				header('Location: http://'.$_SERVER["HTTP_HOST"].'/'.PROJECT_DIRECTORY.'dashboard');
			} else {
				require_once BACK_VIEWS_PATH . 'login.phtml';
			}
			$result = new Result();
			return $result;
		});
		
		$this->post(ROUTE_PATH . 'dashboard/connect', function () {
			$userObj = new User();
			$user = $userObj->postConnect();
			if($user) {
				header('Location: http://'.$_SERVER["HTTP_HOST"].'/'.PROJECT_DIRECTORY.'dashboard');
			} else {
				require_once BACK_VIEWS_PATH . 'login.phtml';
			}
			$result = new Result();
			return $result;
		});

		$this->get(ROUTE_PATH, function () {
			header('Location: ' . HTTP_PATH . 'index');
		});

		$this->get(ROUTE_PATH . 'index', function () {
			require_once FRONT_VIEWS_PATH . 'index.phtml';
			$result = new Result();
			return $result;
		});
		
		$this->get(ROUTE_PATH . 'index/', function () {
			require_once FRONT_VIEWS_PATH . 'index.phtml';
			$result = new Result();
			return $result;
		});
		
		/* DASHBOARD INDEX */
		
		$this->get(ROUTE_PATH . 'dashboard/index', function () {
			is_admin();
			$content = new \app\controllers\Content();
			$nbProduct = count($content->getProductList());
			$user = new \app\controllers\User();
			$nbUser = count($user->getUser_list());
			require_once BACK_VIEWS_PATH . 'index.phtml';
			$result = new Result();
			return $result;
		});
		
		$this->get(ROUTE_PATH . 'dashboard/', function () {
			is_admin();
			$content = new \app\controllers\Content();
			$nbProduct = count($content->getProductList());
			$user = new \app\controllers\User();
			$nbUser = count($user->getUser_list());

			require_once BACK_VIEWS_PATH . 'index.phtml';
			$result = new Result();
			return $result;
		});
		
		$this->get(ROUTE_PATH . 'dashboard', function () {
			is_admin();
			$content = new \app\controllers\Content();
			$nbProduct = count($content->getProductList());
			$user = new \app\controllers\User();
			$nbUser = count($user->getUser_list());

			require_once BACK_VIEWS_PATH . 'index.phtml';
			$result = new Result();
			return $result;
		});
		
		$this->get(ROUTE_PATH . 'logout', function () {
            
            if (isset($_SESSION['user'])) {
                unset($_SESSION['user']);
                session_destroy();
            }
            $this->getResponse()->redirect('index');
        });
        
        $this->get(ROUTE_PATH . 'dashboard/logout', function () {
            if (isset($_SESSION['user'])) {
                unset($_SESSION['user']);
                session_destroy();
            }
            unset($_SESSION['loged']);
            $this->getResponse()->redirect('index');
        });
        
        require_once('routes.php');
		$_SESSION['routes'] = $routes;
		
        foreach($routes as $key => $route) {
			$id = $route['id'];
			if (!$id) {
				$this->$route['type'](ROUTE_PATH . $key, function () {
					$key = str_replace('/'.PROJECT_DIRECTORY, '',$this->getRequest()->getUri()); 
					$route = $_SESSION['routes'][$key];

					$controllerName = $route['controller'];
					$controllerActionResultName = $route['controller'].'s';
					$controllerActionName = $route['type'].$route['action'];
					$controllerObjectName = $route['path'].'\controllers\\'.$controllerName;
					
					$controllerView = $route['view'];
					
					$$controllerName = new $controllerObjectName();
					$$controllerActionResultName = $$controllerName->$controllerActionName();
					
					require_once FRONT_VIEWS_PATH . $controllerName . DS . $controllerView.'.phtml';
					
					$result = new Result();
					return $result;
				});
			} else {
				$this->$route['type'](ROUTE_PATH . $key, function ($id) {
					$key = str_replace('/'.PROJECT_DIRECTORY, '',$this->getRequest()->getParams()['route']); 
					$route = $_SESSION['routes'][$key];

					$controllerName = $route['controller'];
					$controllerActionResultName = $route['controller'].'s';
					$controllerActionName = $route['type'].$route['action'];
					$controllerObjectName = $route['path'].'\controllers\\'.$controllerName;
					$controllerView = $route['view'];
	
					$$controllerName = new $controllerObjectName();
					$$controllerActionResultName = $$controllerName->$controllerActionName($id);
					
					require_once FRONT_VIEWS_PATH . $controllerName . DS . $controllerView.'.phtml';

					$result = new Result();
					return $result;
				});
			}
        }    
    }

    public function serve() {
        $route = $this->getRouter()->run();
        $error404 = new Result404();

        if ($route instanceof Route) {
            $result = call_user_func_array(
				$route->getAction(), $this->getRequest()->getParams()
            );
            if (!($result instanceof Result)) {
                $result = $error404;
            }
            
        } else {
            $result = $error404;
        }

        if ($this->render($result)) {
            print $this->render($result);
        }
    }

    protected function render(Result $result) {
        $response = $this->getResponse();
        $response->setBody($result->data);
        return $response->output();
    }

    public function getRequest() {
        return $this->request;
    }

    public function getRouter() {
        return $this->router;

    }

    public function getResponse() {
        return $this->response;
    }

    public function setRequest(Request $request) {
    	
        $this->request = $request;
        return $this;
    }

    public function setRouter(Router $router) {
        $this->router = $router;
        return $this;
    }

    public function setResponse(Response $response) {
        $this->response = $response;
        return $this;
    }

    public function get($route, $action) {
		return $this->addService('GET', $route, $action);
    }

    public function post($route, $action) {
        return $this->addService('POST', $route, $action);
    }

    public function put($route, $action) {
        return $this->addService('PUT', $route, $action);
    }

    public function delete($route, $action) {
        return $this->addService('DELETE', $route, $action);
    }

    protected function addService($method, $uri, $action, $params = NULL) {
        $route = new Route($method, $uri, $action, $params);
        $this->getRouter()->addRoute($route);
        return $this;
    }

}
