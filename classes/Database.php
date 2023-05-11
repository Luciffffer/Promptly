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
            
            $options = [];

            if (isset($config['db_ssl_cert']) && !empty($config['db_ssl_cert'])) {
                $options = [
                    PDO::MYSQL_ATTR_SSL_CA => $config['db_ssl_cert'],
                    PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false
                ];
            }
            
            self::$PDO = new PDO('mysql:host=' . $config['db_host'] . ';dbname=' . $config['db_name'], $config['db_user'], $config['db_password'], $options);
            
            return self::$PDO;
        }
    }
}