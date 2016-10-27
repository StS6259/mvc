<?php

namespace core;

class View
{
    /**
     * View constructor.
     * @param $path
     * @param $arguments
     * @throws \Exception
     */
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