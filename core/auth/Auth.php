<?php

namespace core\auth;

use application\components\IpApi;
use application\models\MemberIpsModel;
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
        $ip = $_SERVER['REMOTE_ADDR'];
        $ip = '141.101.5.45'; //todo delete in prod

        $ips = (new MemberIpsModel())
            ->where('ip', $ip)
            ->where('member_id', $member->result['id'])
            ->all();
        $countyCode = IpApi::getCountryCode($ip);
        if (empty($ips)) {
            (new MemberIpsModel())->create([
                'member_id' => $member->result['id'],
                'ip' => $ip,
                'country_code' => $countyCode,
            ]);
        }
        $_SESSION['user_id'] = $member->result['id'];
        $_SESSION['country_code'] = $countyCode;
    }

    public static function getCountryCode()
    {
        return $_SESSION['country_code'] ?? null;
    }

    public static function user()
    {
        return (new MemberModel())->find($_SESSION['user_id']);
    }

    public static function getUserId()
    {
        return $_SESSION['user_id'];
    }

}