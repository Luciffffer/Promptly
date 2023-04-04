<?php

require_once(__DIR__ . "/Database.php");
require_once(__DIR__ . '/../vendor/autoload.php');
use Postmark\PostmarkClient;

class Email
{
    public static function generateVerificationCode (): string // Can create unique id's for 3050 people currently. Feel free to improve
    {
        $permittedChars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $PDO = Database::getInstance();
        $unique = false;

        while ($unique === false) {
            $string = substr(str_shuffle($permittedChars), 0, 50);

            $stmt = $PDO->prepare("select * from users where email_verification_code = :code");
            $stmt->bindValue(":code", $string);
            $stmt->execute();

            if ($stmt->fetch() == false) {
                $unique = true;
                return $string;
            }
        }
    }
}