<?php

require_once(__DIR__ . "/Database.php");

class Prompt
{
    // AI model methods

    public static function getAllModels()
    {
        $PDO = Database::getInstance();
        $stmt = $PDO->query("select * from ai_models");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getModelVersions(int $id)
    {
        $PDO = Database::getInstance();
        $stmt = $PDO->prepare("select versions from ai_models where id = :id");
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $result = json_decode($result['versions']);

        return $result;
    }

    // Category methods

    public static function getAllCategories() 
    {
        $PDO = Database::getInstance();
        $stmt = $PDO->query("select * from categories");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}