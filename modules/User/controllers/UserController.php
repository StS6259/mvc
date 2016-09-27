<?php
namespace modules\User\controllers;

use core\controllers\BaseController;
use modules\User\models\User;

class UserController extends BaseController
{
    public function index()
    {
//        $obj = (new User())->where('id', 1)->all();
//        $obj = (new User())->where('age','between', 20, 50)->orWhereBetween('id', 1, 10)->all();
        $obj = (new User())->where('age', 'between', 20, 50)->orderBy('id', 'DESC')->all();
        return $this->view('index', [
            'request_result' => $obj
        ]);
    }

    public function hello()
    {
        echo "<h1>Hello!</h1>";
    }

    public function seeName($name)
    {
        echo "Your name is $name?";
    }


}