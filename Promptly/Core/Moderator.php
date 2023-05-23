<?php

namespace Promptly\Core;

use \PDO;

require_once(__DIR__ . '/../../vendor/autoload.php');

class Moderator extends User
{
    public static function isMod($id)
    {
        $PDO = Database::getInstance();
        $statement = $PDO->prepare("SELECT * FROM `users` WHERE isMod = 1 AND id = :id");
        $statement->bindValue(':id', $id);
        $statement->execute();
        // $result = $statement->fetch(PDO::FETCH_ASSOC);
    }
}
