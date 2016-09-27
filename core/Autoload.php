<?php

class Autoload
{
    protected $class;

    public function __construct($class)
    {
        $this->class = $class;
    }

    public function load()
    {
        $path = core\Config::get("root__path") . str_replace("\\", "/", $this->class) . ".php";
        if (file_exists($path)) {
            include $path;
        } else {
            throw new Exception('No such file! ' . $path);
        }
    }
}