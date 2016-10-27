<?php

namespace core\auth;

use application\models\MemberModel;

class Auth
{
    public static function check()
    {
        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] >= 1) {
            return true;
        }

        return false;
    }

    public static function logout()
    {
        session_destroy();
    }

    /**
     * @param \core\auth\Authenticated $member
     */
    public static function login(Authenticated $member)
    {
        $_SESSION['user_id'] = $member->result['id'];
    }

    public static function user()
    {
        return (new MemberModel())->find($_SESSION['user_id']);
    }
}