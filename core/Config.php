<?php
namespace core;

class Config
{
    private static $_data = [];

    /**
     * @param $key
     * @param null $defaultValue
     * @return mixed|null
     */
    public static function get($key, $defaultValue = null)
    {
        return self::$_data[$key] ?? $defaultValue;
    }

    /**
     * @param $key
     * @param $value
     */
    public static function set($key, $value)
    {
        if(!key_exists($key, self::$_data)) {
            self::$_data[$key] = $value;
        }
    }

    private function __construct() {}

    private function __sleep() {}

    private function __wakeup() {}

    private function __clone() {}
}