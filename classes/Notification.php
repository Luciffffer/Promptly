<?php

require_once(__DIR__ . '/Database.php');

class Notification
{
    private $message;
    private $userId;
    private $link;
    private $image;


    // Setters

    public function setMessage (string $message)
    {
        $this->message = $message;
        return $this;
    }

    public function setUserId (int $userId) 
    {
        $this->userId = $userId;
        return $this;
    }

    public function setLink (string $link)
    {
        $this->link = $link;
        return $this;
    }

    public function setImage (string $image)
    {
        $this->image = $image;
        return $this;
    }


    // Insert, update, delete

    public function save(): void
    {
        $PDO = Database::getInstance();

        $statement = $PDO->prepare("INSERT INTO notifications (message, user_id, link, image) VALUES (:message, :userId, :link, :image)");
        $statement->bindValue(":message", $this->message, PDO::PARAM_STR);
        $statement->bindValue(":userId", $this->userId, PDO::PARAM_INT);
        $statement->bindValue(":link", $this->link, PDO::PARAM_STR);
        $statement->bindValue(":image", $this->image, PDO::PARAM_STR);
        $statement->execute();
    }

    public static function setViewedByUserId (int $userId): void
    {
        $PDO = Database::getInstance();

        $statement = $PDO->prepare("UPDATE notifications SET viewed = 1 WHERE user_id = :userId");
        $statement->bindValue(":userId", $userId, PDO::PARAM_INT);
        $statement->execute();
    }


    // Get notifications

    public static function getNonViewedNotificationCountByUserId (int $userId)
    {
        $PDO = Database::getInstance();

        $statement = $PDO->prepare("SELECT * FROM notifications WHERE user_id = :userId AND viewed = 0 LIMIT 10");
        $statement->bindValue(":userId", $userId, PDO::PARAM_INT);
        $statement->execute();

        $count = $statement->rowCount();

        if ($count > 9) {
            return "9+";
        } else {
            return $count;
        }
    }

    public static function getNotificationsByUserId (int $userId): array
    {
        $PDO = Database::getInstance();

        $statement = $PDO->prepare("SELECT * FROM notifications WHERE user_id = :userId ORDER BY date_created DESC");
        $statement->bindValue(":userId", $userId, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}