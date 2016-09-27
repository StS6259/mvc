<?php
namespace core;

use modules\User\controllers\UserController;

class Route
{
    const DEFAULT_ACTION = "index";

    protected $routes;
    protected $params;
    protected $conf;

    function __construct($router)
    {
        $this->conf = $router;
        $this->parseUrl();
        $this->getRoute();
    }

    protected function getRoute()
    {
        switch (count($this->routes)) {
            case 0: {
                return $this->callDefaultController();
            }
            case 1: {
                return $this->callControllerDefaultAction();
            }
            case 2: {
                return $this->callControllerAction();
            }
            case 3: {
                return $this->callModuleControllerAction();
            }
        }
    }

    protected function callDefaultController()
    {
        $this->callFunction(
            $this->conf['default_controller'],
            $this->conf['default_controller_default_action']
        );
    }

    protected function callControllerDefaultAction()
    {
        $class = $this->conf['controllers'] . ucfirst($this->routes[0]) . "Controller";
        $this->callFunction($class, self::DEFAULT_ACTION);
    }

    protected function callControllerAction()
    {
        $action = $this->routes[1];
        $class = $this->conf['controllers'] . ucfirst($this->routes[0]) . "Controller";
        $this->callFunction($class, $action);
    }

    protected function callModuleControllerAction()
    {
        $action = $this->routes[2];
        $class = $this->conf['modules'] . ucfirst($this->routes[0]) . "\\controllers\\" . ucfirst($this->routes[1]) . "Controller";
        $this->callFunction($class, $action);
    }

    protected function callFunction($class, $action)
    {
        $obj = new $class();
        $actionParameters = (new \ReflectionMethod ($obj, $action))->getParameters();
        $numberOfParameters = count($actionParameters);
        if ($numberOfParameters === 0) {
            call_user_func_array([$obj, $action], []);
        } elseif ($numberOfParameters !== 0 && $this->params === null) {
            throw new \Exception("You haven't set any parameters to call a function! It needs $numberOfParameters arguments.");
        } else {
            foreach ($actionParameters as $key => $value) {
                if (!key_exists($value->name, $this->params)) {
                    throw new \Exception("You haven't set \"$value->name\" value. Not enough parameters to call a function!");
                } else {
                    $newArgumentsOrder[] = $this->params[$value->name];
                }
            }
            call_user_func_array([$obj, $action], $newArgumentsOrder);
        }
    }

    public function parseUrl()
    {
        $address = explode("?", $_SERVER["REQUEST_URI"]);
        if (isset($address[1])) {
            $params = explode("&", $address[1]);
            foreach ($params as $item) {
                $couples = explode("=", $item);
                if ($couples[1] !== "") {
                    $this->params[$couples[0]] = $couples[1];
                }
            }
        }
        $files = explode("/", $address[0]);
        foreach ($files as $file) {
            if ($file !== "") {
                $this->routes[] = $file;
            }
        }
    }
}