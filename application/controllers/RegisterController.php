<?php

namespace application\controllers;

use application\models\MemberModel;
use core\auth\Auth;
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
            $member = $this->createMember($post);

            Auth::login($member);
            return $this->redirect('/');
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
            return false;
        }
        if (!isset($request['email']) || !filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        if (!isset($request['password']) || !isset($request['repeat_password']) || strlen($request['password']) < 6 ||
            $request['password'] !== $request['repeat_password']) {
            return false;
        }
        $members = (new MemberModel())
            ->where('email', $request['email'])
            ->orwhere('nickname', $request['nickname'])
            ->all();
        if (!empty($members)) {
            return false;
        }

        return true;
    }
}