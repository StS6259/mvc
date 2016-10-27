<?php

namespace core\auth;

use application\components\IpApi;
use application\models\MemberIpsModel;
use application\models\MemberModel;

class Auth
{
    /**
     * check if user user login in
     * @return bool
     */
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
        $_SESSION['user_name'] = $member->result['nickname'];
    }

    /**
     * @return 'country_code' ||null
     */
    public static function getCountryCode()
    {
        return self::getDataFromSession('country_code');
    }

    /**
     *
     * @return $this|null (currentUser)
     */
    public static function user()
    {
        return (new MemberModel())->find($_SESSION['user_id']);
    }

    /**
     * @return mixed (current user id)
     */
    public static function getUserId()
    {
        return self::getDataFromSession('user_id');

    }

    public static function getNickName()
    {
        return self::getDataFromSession('user_name');
    }

    protected function getDataFromSession($key)
    {
        return $_SESSION[$key] ?? null;
    }

}