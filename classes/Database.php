<?php

class Database 
{
    private static $PDO;

    public static function getInstance()
    {
        if (self::$PDO != null) {
            return self::$PDO;
        } else {
            $config = parse_ini_file(__DIR__ . "/../config/config.ini");
            self::$PDO = new PDO($config['db_conn_string'], $config['db_user'], $config['db_password']);
            
            return self::$PDO;
        }
    }
}