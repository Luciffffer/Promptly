<?php

class Database 
{
    private static $PDO;

    public static function getInstance()
    {
        if (self::$PDO != null) {
            return self::$PDO;
        } else {
            $config = parse_ini_file("config/config.ini");
            self::$PDO = new PDO('mysql:host=' . $config['db_host'] . ';dbname=' . $config['db_name'], $config['db_user'], $config['db_password']);
            
            return self::$PDO;
        }
    }
}