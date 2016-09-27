<?php
namespace core\controllers;


use core\Config;
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
        $class = new \ReflectionClass($this);
        $nameSpace = explode('\\', $class->getName());
        $controllerName = substr_replace(strtolower($nameSpace[count($nameSpace) - 1]), '', -10);
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