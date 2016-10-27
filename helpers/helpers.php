<?php
if (!function_exists('dd')) {
    function dd (...$data) {
        var_dump(...$data); die;
    }
}
if (!function_exists('route')) {
    function route($string) {
        $url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];
        if ($string == '/') {
            return $url . '/';
        }
        return $url . '/' . $string;
    }
}

