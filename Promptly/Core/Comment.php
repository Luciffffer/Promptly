<?php

namespace Promptly\Core;

use \PDO;
use \Exception;

require_once(__DIR__ . '/../../vendor/autoload.php');

class Comment
{
    private int $promptId;
    private int $userId;
    private string $comment;


    // Setters

    public function setPromptId(int $promptId): self
    {
        $this->promptId = $promptId;
        return $this;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    public function setComment(string $comment): self
    {
        if (empty($comment)) {
            throw new Exception('Comment is required and cannot be empty');
        } elseif (strlen($comment) > 300) {
            throw new Exception('Comment cannot be longer than 300 characters');
        }

        $this->comment = $comment;
        return $this;
    }


    // Insert, update, delete

    public function saveComment(): void
    {
        $PDO = Database::getInstance();
        $stmt = $PDO->prepare('INSERT INTO comments (prompt_id, user_id, comment) VALUES (:promptId, :userId, :comment)');
        $stmt->bindValue(':promptId', $this->promptId, PDO::PARAM_INT);
        $stmt->bindValue(':userId', $this->userId, PDO::PARAM_INT);
        $stmt->bindValue(':comment', $this->comment);
        $stmt->execute();
    }

    public static function removeComment(int $commentId): void
    {
        $PDO = Database::getInstance();
        $stmt = $PDO->prepare('DELETE FROM comments WHERE id = :commentId');
        $stmt->bindValue(':commentId', $commentId, PDO::PARAM_INT);
        $stmt->execute();
    }


    // get commments

    public static function getAllComments(int $promptId): array
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('SELECT * FROM comments WHERE prompt_id = :promptId ORDER BY date_created DESC');
        $stmt->bindValue(':promptId', $promptId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getAllCommentsInformationForDisplay(int $promptId): array
    {
        $PDO = Database::getInstance();
        $stmt = $PDO->prepare('SELECT comments.*, users.username, users.profile_pic, users.verified FROM comments INNER JOIN users ON comments.user_id = users.id WHERE comments.prompt_id = :promptId ORDER BY date_created DESC');
        $stmt->bindValue(':promptId', $promptId, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $key => $comment) {
            $results[$key]['date_created'] = \Promptly\Helpers\Date::getElapsedTime($comment['date_created']);
            $results[$key]['comment'] = htmlspecialchars($comment['comment']);
        }

        return $results;
    }

    public static function getCommentById(int $id): array
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('SELECT * FROM comments WHERE id = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
