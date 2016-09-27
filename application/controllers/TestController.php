<?php

namespace application\controllers;

use application\models\TestModel;
use core\controllers\BaseController;

class TestController extends BaseController
{
    public function test($from, $to)
    {
        $data = (new TestModel())
            ->select(['id', 'name', 'age', 'text', 'created_at', 'updated_at'])
            ->where('id', '!=', 100000)
            ->whereBetween('id', $from, $to)
            ->orderBy('id', 'desc')
            ->all();

        return $this->view('test', [
            'test' => $data
        ]);
    }
}