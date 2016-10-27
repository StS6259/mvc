<?php
if (!function_exists('dd')) {
    function dd (...$data) {
        var_dump(...$data); die;
    }
}
if (!function_exists('route')) {
    function route($string, $param = []) {
        $string = ltrim($string, '/');
        $url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/' . $string;
        if ($param) {
            return $url . '?' . http_build_query($param);
        }
        return $url;
    }
}

