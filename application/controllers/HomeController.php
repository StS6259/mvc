<?php

namespace application\controllers;

use core\controllers\BaseController;

class HomeController extends BaseController
{
    function index()
    {
        echo "HomeController->index()";
    }

    public function oneParamFunction($firstParam)
    {
        echo "HomeController->oneParamFunction(firstParam = $firstParam)";
    }

    public function test($name, $age)
    {
        return $this->view($this->getViewPath() . 'test', [
            'name' => $name,
            'age' => $age,
        ]);
    }
}