<?php
include_once(__DIR__ . "/Database.php");
include_once(__DIR__ . "/User.php");

class Report
{
    private $user_id;
    private $reason;
    private $description;
    private $report_id;


    public function getReason()
    {
        return $this->reason;
    }

    public function setReason($reason)
    {
        $this->reason = $reason;

        return $this;
    }

    public function getReport_id()
    {
        return $this->report_id;
    }


    public function setReport_id($report_id)
    {
        $this->report_id = $report_id;

        return $this;
    }

    public function getUser_id()
    {
        return $this->user_id;
    }

    

    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    // Insert into database

    public function saveReport(): void
    {
        $PDO = Database::getInstance();
        $stmt = $PDO->prepare("INSERT INTO report(user_id, reason, description, reporter_id) VALUES (:user_id, :reason, :description, :reporter_id)");
        $stmt->bindValue(':user_id', $this->user_id);
        $stmt->bindValue(':reason', $this->reason);
        $stmt->bindValue(':description', $this->description);
        $stmt->bindValue(':reporter_id', $this->report_id);
        $stmt->execute();
    }
}