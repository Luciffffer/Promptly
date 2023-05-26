<?php

namespace Promptly\Core;

require_once(__DIR__ . "/../../vendor/autoload.php");

use \PDO;

class Sale
{
    private int $userId;
    private int $promptId;

    // Setters

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    public function setPromptId(int $promptId): self
    {
        $this->promptId = $promptId;
        return $this;
    }

    // Insert, update, delete

    public function save(): void
    {
        $PDO = Database::getInstance();
        $stmt = $PDO->prepare('INSERT INTO sales (user_id, prompt_id) VALUES (:userId, :promptId)');
        $stmt->bindValue(':userId', $this->userId, PDO::PARAM_INT);
        $stmt->bindValue(':promptId', $this->promptId, PDO::PARAM_INT);
        $stmt->execute();
    }


    // Get from DB

    public static function saleExists(int $userId, int $promptId): bool
    {
        $PDO = Database::getInstance();
        $stmt = $PDO->prepare('SELECT COUNT(*) FROM sales WHERE user_id = :userId AND prompt_id = :promptId');
        $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':promptId', $promptId, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_NUM);
        return $result[0] > 0;
    }
}
