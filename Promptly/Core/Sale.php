<?php

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
}
