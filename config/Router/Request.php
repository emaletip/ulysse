<?php

namespace config\Router;

class Request
{
    private $uri;
    private $body;
    private $params = array();

    public function __construct($uri = null)
    {
        if ($uri === null) {
            $uri = $this->getServer('REQUEST_URI');
        }
        $this->setUri($uri);
    }

    public function setParam($key, $value)
    {
        $this->params[$key] = $value;
        return $this;
    }

    public function getParam($key)
    {
        if (isset($this->params[$key])) {
            return $this->params[$key];
        }
        return null;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function setParams(array $params)
    {
        foreach ($params as $key => $value) {
            $this->setParam($key, $value);
        }
        return $this;
    }

    public function setUri($uri)
    {
        $this->uri = (string) $uri;
        return $this;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getGet($key = null)
    {
        if (null === $key) {
            return $_GET;
        }

        if (isset($_GET[$key])) {
            return $_GET[$key];
        }
        return null;
    }

    public function getPost($key = null)
    {
        if (null === $key) {
            return $_POST;
        }

        if (isset($_POST[$key])) {
            return $_POST[$key];
        }
        return null;
    }

    public function getPut()
    {
        return $this->getBody();
    }

    public function getBody()
    {
        if (null === $this->body) {
            $body = file_get_contents('php://input');
            if (strlen(trim($body)) > 0) {
                parse_str($body, $this->body);
            }
        }
        return $this->body;
    }

    public function getMethod()
    {
        return $this->getServer('REQUEST_METHOD');
    }

    public function getServer($key = null)
    {
        if ($key === null) {
            return $_SERVER;
        }
        $key = strtoupper($key);

        if (isset($_SERVER[$key])) {
            return $_SERVER[$key];
        }
        return null;
    }
}
