<?php
if (!function_exists('dd')) {
    function dd (...$data) {
        var_dump(...$data); die;
    }
}
if (!function_exists('route')) {
    function route($string) {
        $string = ltrim($string, '/');
        return $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/' . $string;
    }
}

