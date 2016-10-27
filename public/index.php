<?php
ini_set('display_errors', 1);
session_start();
require_once("../core/Config.php");
core\Config::set('start_time', microtime());
require_once('../core/Autoload.php');
require_once('../helpers/helpers.php');
set_exception_handler(function ($exception) {
    echo $exception->getMessage();
});
core\Config::set('root__path', __DIR__ . '/../');
$configRoute = require_once('../configs/router.php');

spl_autoload_register(function ($className) {
    (new Autoload($className))->load();
});
require_once('../helpers/helpers.php');

$route = new \core\Route($configRoute);
//0,01646
?>
