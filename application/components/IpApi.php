<?php

namespace application\components;

final class IpApi
{
    public static function getGeo($ip = null)
    {
        if ($ip === null) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return self::sendRequest($ip);
    }

    public static function getCountryCode($ip = null)
    {
        if ($ip === null) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        $data = self::getGeo($ip);
        return $data['countryCode'] ?? null;
    }

    private static function sendRequest($ip)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "http://ip-api.com/json/" . $ip,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "cache-control: no-cache",
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return  json_decode($response, true);
        }
    }
}