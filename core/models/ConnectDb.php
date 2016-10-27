<?php

namespace core\models;

class ConnectDb
{
    protected static $connection = null;

    private function __construct() {}

    private function __sleep() {}

    private function __clone() {}

    private function __wakeup() {}

    /**
     * create db connection
     */
    public static function connectDb()
    {
        $conf = require(__DIR__ . '/../../configs/db.php');
        self::$connection = new \PDO("mysql:host=" . $conf['dbhost'] . ";dbname=" . $conf['dbname'], $conf['dbuser'], $conf['dbpass']);
        self::$connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    /**
     * return db connection
     * @return null
     */
    public static function getConnection()
    {
        if (self::$connection === null) {
            self::connectDb();
        }
        return self::$connection;
    }
}