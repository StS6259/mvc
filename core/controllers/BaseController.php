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

    /**
     * generate view path
     * @return string
     * @throws \Exception
     */
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

    /**
     * if user unauthenticated - redirect to login page
     */
    protected function checkIfAuthenticated()
    {
        if (!Auth::check()) {
            $this->redirect('/login');
        }
    }

    /**
     * if user authenticated - redirect to main page
     */
    protected function checkIfGuest()
    {
        if (Auth::check()) {
            $this->redirect('/');
        }
    }

    /**
     * @param $route
     */
    protected function redirect($route)
    {
        header('Location: ' . route($route));
    }

    /**
     * @param string $route
     */
    protected function checkForPost($route = '/')
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect($route);
        }
    }

}