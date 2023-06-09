<?php

namespace Promptly\Core;

require_once(__DIR__ . '/../../vendor/autoload.php');

use \PDO;

class Achievement
{
    public static function unlockAchievement($achievementId, $userId)
    {
        $PDO = Database::getInstance();

        $statement = $PDO->prepare("INSERT INTO achievement_user (achievement_id, user_id) VALUES (:achievementId, :userId)");
        $statement->bindValue(":achievementId", $achievementId, PDO::PARAM_INT);
        $statement->bindValue(":userId", $userId, PDO::PARAM_INT);
        $statement->execute();

        $achievement = self::getAchievementById($achievementId);

        // send notification
        $notification = new Notification();
        $notification->setMessage("You unlocked the achievement: " . $achievement['title']);
        $notification->setUserId($userId);
        $notification->setLink("profile?id=" . $userId);
        $notification->setImage($achievement['cover']);
        $notification->save();
    }

    public static function getAchievementById($achievementId)
    {
        $PDO = Database::getInstance();

        $statement = $PDO->prepare("SELECT * FROM achievements WHERE id = :achievementId");
        $statement->bindValue(":achievementId", $achievementId);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public static function getAchievementsByUserId($userId)
    {
        $PDO = Database::getInstance();
        $statement = $PDO->prepare("SELECT achievements.* FROM achievements INNER JOIN achievement_user ON achievement_user.achievement_id = achievements.id WHERE achievement_user.user_id = :userId");
        $statement->bindValue(":userId", $userId);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
