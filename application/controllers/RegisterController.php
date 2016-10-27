<?php

namespace application\controllers;

use application\models\MemberModel;
use application\components\Messages;
use core\controllers\BaseController;
use core\Hash;

class RegisterController extends BaseController
{
    public function index()
    {
        $this->checkIfGuest();

        return $this->view('registerForm');
    }

    public function register()
    {
        $this->checkIfGuest();

        $post = $_POST;
        if ($this->validateRegister($post)) {
            $this->createMember($post);
            return $this->redirect('/login');
        }

        return $this->redirect('/register');
    }

    protected function createMember($data)
    {
        return (new MemberModel)->create([
            'nickname' => $data['nickname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    protected function validateRegister($request)
    {
        if (!isset($request['nickname']) || strlen($request['nickname']) < 4) {
            Messages::error(['Invalid nickname field.']);
            return false;
        }
        if (!isset($request['email']) || !filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
            Messages::error(['Invalid email field.']);
            return false;
        }

        if (!isset($request['password']) || !isset($request['repeat_password']) || strlen($request['password']) < 6 ||
            $request['password'] !== $request['repeat_password']) {
            Messages::error(['Invalid passwords fields.']);
            return false;
        }
        $members = (new MemberModel())
            ->where('email', $request['email'])
            ->orwhere('nickname', $request['nickname'])
            ->all();
        if (!empty($members)) {
            Messages::error(['email or nickname already exist.']);
            return false;
        }

        return true;
    }
}