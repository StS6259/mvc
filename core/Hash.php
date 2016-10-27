<?php

namespace core;

final class Hash
{
    public static function make($string)
    {
        return md5(md5($string));
    }

    public static function check($string, $hash)
    {
        return self::make($string) === $hash;
    }
}