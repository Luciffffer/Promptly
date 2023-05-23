<?php

namespace Promptly\Core;

use \PDO;

require_once(__DIR__ . '/../../vendor/autoload.php');

class like
{
    //get likes from database
    public static function getLikes($promptId)
    {
        $pdo = Database::getInstance();

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM likes WHERE prompt_id = :prompt_id");
        $stmt->bindParam(':prompt_id', $promptId, PDO::PARAM_INT);
        $stmt->execute();
        $likes = $stmt->fetchColumn();

        return $likes;

    }

    public static function getLikesByUserId(int $userId): int
    {
        $pdo = Database::getInstance();

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM likes WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $likes = $stmt->fetchColumn();

        return $likes;
    }

    public function toggleLike($promptId, $userId)
    {
        $pdo = Database::getInstance();

        if ($this::isLiked($userId, $promptId)) {
            // User has already liked the prompt, so remove their like
            $stmt = $pdo->prepare("DELETE FROM likes WHERE prompt_id = :prompt_id AND user_id = :user_id");
            $stmt->bindParam(':prompt_id', $promptId, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            echo "removed"; // don't echo stuff in classes. Just return it
        } else {
            // User hasn't liked the prompt yet, so add their like
            $stmt = $pdo->prepare("INSERT INTO likes (prompt_id, user_id) VALUES (:prompt_id, :user_id)");
            $stmt->bindParam(':prompt_id', $promptId, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            echo "added"; // don't echo stuff in classes. Just return it
        }

    }

    public static function isLiked($userId, $promptId): bool
    {
        $pdo = Database::getInstance();

        $stmt = $pdo->prepare("SELECT * FROM likes WHERE prompt_id = :prompt_id AND user_id = :user_id");
        $stmt->bindParam(':prompt_id', $promptId, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();

        return $result ? true : false;
    }
}
