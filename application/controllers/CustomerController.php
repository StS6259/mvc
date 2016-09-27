<?php
namespace application\controllers;

use core\controllers\BaseController;

class CustomerController extends BaseController
{
    function index()
    {

        return $this->view('index');
    }

    public function seeName($name, $surname, $age)
    {
        echo "Hello! $name $surname $age";
    }
}