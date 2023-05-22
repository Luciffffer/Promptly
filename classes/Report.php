<?php
include_once(__DIR__ . "/Database.php");

class Report // Zegher please structure this a little better. Seperate the setters and getters pls xoxo
{
    private $userId = null;
    private $promptId = null;
    private int $id;
    private $reason;
    private $extraInformation;
    private $reporterId;


    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setPromptId (int $promptId)
    {
        $this->promptId = $promptId;
        return $this;
    }

    public function getReason()
    {
        return $this->reason;
    }

    public function setReason($reason)
    {
        $this->reason = $reason;

        return $this;
    }

    public function getReporterId()
    {
        return $this->reporterId;
    }


    public function setReporterId($reporter_id)
    {
        $this->reporterId = $reporter_id;

        return $this;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    

    public function setUserId(int $user_id)
    {
        $this->userId = $user_id;

        return $this;
    }

    public function getExtraInformation()
    {
        return $this->extraInformation;
    }

    public function setExtraInformation($description)
    {
        $this->extraInformation = $description;

        return $this;
    }

    // Insert into database

    public function saveReport(): void
    {
        $PDO = Database::getInstance();
        $stmt = $PDO->prepare("INSERT INTO reports(user_id, reason, extra_information, reporter_id) VALUES (:user_id, :reason, :extra_information, :reporter_id)");
        $stmt->bindValue(':user_id', $this->userId);
        $stmt->bindValue(':reason', $this->reason);
        $stmt->bindValue(':extra_information', $this->extraInformation);
        $stmt->bindValue(':reporter_id', $this->reporterId);
        $stmt->execute();
    }

    // get alles
    public function getUserReports()
    {
        $PDO = Database::getInstance();
        $stmt = $PDO->prepare("SELECT * FROM reports WHERE user_id IS NOT NULL AND LENGTH(user_id) > 0");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function getReportById(int $id): array
    {
        $PDO = Database::getInstance();
        $stmt = $PDO->prepare("SELECT * FROM reports WHERE id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    //delete report na blocken/denyen
    public function removeReport(): void
    {
        $PDO = Database::getInstance();
        $stmt = $PDO->prepare("DELETE FROM reports WHERE id = :id"); 
        $stmt->bindValue(':id', $this->id);
        $stmt->execute();
    }
}