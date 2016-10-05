<?php
namespace core\controllers;


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
}