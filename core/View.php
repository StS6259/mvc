<?php

namespace core;

class View
{
    function __construct($path, $arguments)
    {
        $pathView = Config::get("root__path") . $path . ".php";
        if (file_exists($pathView)) {
            extract($arguments);
            unset($arguments);
            require $pathView;
        } else {
            throw new \Exception("File does not exist! $pathView");
        }
    }
}