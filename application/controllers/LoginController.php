<?php

namespace application\controllers;

use application\components\Messages;
use application\models\MemberModel;
use core\auth\Auth;
use core\controllers\BaseController;
use core\Hash;

class LoginController extends BaseController
{
    /**
     * show login form
     * @return \core\View
     */
    public function index()
    {
        $this->checkIfGuest();
        return $this->view('loginForm');
    }


    public function logout()
    {
        $this->checkIfAuthenticated();
        Auth::logout();
        return $this->redirect('/');
    }

    /**
     * action for login user
     */
    public function login()
    {
        $this->checkForPost();
        $data = $_POST;
        if (($member = $this->validateLogin($data)) !== false) {
            Auth::login($member);
        } else {
            Messages::error(['Invalid nickname or password.']);
        }

        $this->redirect('/login');
    }

    /**
     * action for validate login form
     * @param $request
     * @return $this|bool
     */
    protected function validateLogin($request)
    {
        if (!isset($request['nickname']) || strlen($request['nickname']) < 4) {
            return false;
        }
        if (!isset($request['password']) || strlen($request['password']) < 4) {
            return false;
        }
        $member = (new MemberModel())->find(['nickname' => $request['nickname']]);
        if ($member === null || !Hash::check($request['password'], $member->result['password'])) {
            return false;
        }
        return $member;
    }
}