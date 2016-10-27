<?php

namespace core\controllers;

use core\auth\Auth;
use core\View;

class BaseController
{
    protected $directory;

    protected function view($view, $arguments = [])
    {
        return new View($this->getViewPath() . $view, $arguments);
    }

    protected function getViewPath()
    {
        $class = get_called_class();
        $nameSpace = explode('\\', $class);
        $controllerName = str_replace('controller' , '' , strtolower($nameSpace[count($nameSpace) - 1]));
        if ($nameSpace[0] === 'application') {
            $path = 'views/' . $controllerName;
        } elseif ($nameSpace[0] === 'modules') {
            $path = $nameSpace[0] . '/' . $nameSpace[1] . '/views/' . $controllerName;
        } else {
            throw new \Exception("Wrong namespace");
        }
        return $path . '/';
    }

    protected function checkLogin()
    {
        if (!Auth::check()) {
            $this->redirect('/login');
        }
    }

    protected function checkIfGuest()
    {
        if (Auth::check()) {
            $this->redirect('/');
        }
    }

    protected function redirect($route)
    {
        header('Location: ' . route($route));
    }

    protected function checkForPost($route = '/')
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect($route);
        }
    }

}