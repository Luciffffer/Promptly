<?php

namespace Promptly\Core;

use PDO;

require_once(__DIR__ . '/../../vendor/autoload.php');

class Follow
{
    private int $followeeId;
    private int $followerId;


    // Setters

    public function setFollowerId(int $followerId): self
    {
        $this->followerId = $followerId;
        return $this;
    }

    public function setFolloweeId(int $followeeId): self
    {
        User::getUserById($followeeId); // check if user exists

        $this->followeeId = $followeeId;
        return $this;
    }


    // Insert

    public function toggleFollow(): string
    {
        if ($this::isFollowing($this->followerId, $this->followeeId)) {
            $this->unfollow();
            return 'unfollowed';
        } else {
            $this->follow();
            return 'followed';
        }
    }

    private function follow(): void
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('INSERT INTO follows (follower_id, followee_id) VALUES (:follower_id, :followee_id)');
        $stmt->bindValue(':follower_id', $this->followerId, PDO::PARAM_INT);
        $stmt->bindValue(':followee_id', $this->followeeId, PDO::PARAM_INT);
        $stmt->execute();
    }

    private function unfollow(): void
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('DELETE FROM follows WHERE follower_id = :follower_id AND followee_id = :followee_id');
        $stmt->bindValue(':follower_id', $this->followerId, PDO::PARAM_INT);
        $stmt->bindValue(':followee_id', $this->followeeId, PDO::PARAM_INT);
        $stmt->execute();
    }


    // Get properties

    public static function getFollowerCount(int $followeeId): int
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('SELECT COUNT(*) FROM follows WHERE followee_id = :followee_id');
        $stmt->bindValue(':followee_id', $followeeId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_NUM)[0];
    }

    public static function isFollowing(int $user_id, int $followeeId): bool
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('SELECT * FROM follows WHERE follower_id = :follower_id AND followee_id = :followee_id');
        $stmt->bindValue(':follower_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':followee_id', $followeeId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) === false ? false : true;
    }
}
