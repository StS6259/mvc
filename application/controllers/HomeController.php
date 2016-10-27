<?php

namespace application\controllers;

use core\controllers\BaseController;

class HomeController extends BaseController
{
    function index()
    {
        return $this->view('index');
    }
}