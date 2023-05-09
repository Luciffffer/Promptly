<?php

require_once(__DIR__ . "/User.php");

class Moderator extends User
{
    public static function isMod($id){
        $PDO = Database::getInstance();
        $statement = $PDO->prepare("SELECT * FROM `users` WHERE isMod = 1 AND id = :id");
        $statement->bindValue(':id', $id);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
    }
}