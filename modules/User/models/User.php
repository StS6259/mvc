<?php
namespace modules\User\models;

use core\models\ModelDb;

class User extends ModelDb
{

    public function seeName($name)
    {
        echo "user = $name";
    }

    public function index()
    {
        echo "user defaultFunction \"index\"<br>";
    }

}