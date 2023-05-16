<?php
require_once(__DIR__ . "/Database.php");

class like
{
    //get likes from database
    public static function getLikes($promptId)
    {
        $pdo = Database::getInstance();
    
        try {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM liked WHERE prompt_id = :prompt_id");
            $stmt->bindParam(':prompt_id', $promptId, PDO::PARAM_INT);
            $stmt->execute();
            $likes = $stmt->fetchColumn();
    
            return $likes;
    
        } catch (PDOException $e) {
            echo "Error getting likes: " . $e->getMessage();
        }
    }
    public function toggleLike($promptId, $userId)
    {
        $pdo = Database::getInstance();

        try {
            $stmt = $pdo->prepare("SELECT * FROM liked WHERE prompt_id = :prompt_id AND user_id = :user_id");
            $stmt->bindParam(':prompt_id', $promptId, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            $like = $stmt->fetch();

            if ($like) {
                // User has already liked the prompt, so remove their like
                $stmt = $pdo->prepare("DELETE FROM liked WHERE prompt_id = :prompt_id AND user_id = :user_id");
                $stmt->bindParam(':prompt_id', $promptId, PDO::PARAM_INT);
                $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
                $stmt->execute();
                echo "removed";
            } else {
                // User hasn't liked the prompt yet, so add their like
                $stmt = $pdo->prepare("INSERT INTO liked (prompt_id, user_id) VALUES (:prompt_id, :user_id)");
                $stmt->bindParam(':prompt_id', $promptId, PDO::PARAM_INT);
                $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
                $stmt->execute();
                echo "added";
            }
        } catch (PDOException $e) {
            echo "Error toggling like: " . $e->getMessage();
        }
    }
    public static function getUserLikes($userId, $promptId)
    {
        $pdo = Database::getInstance();
    
        try {
            $stmt = $pdo->prepare("SELECT * FROM liked WHERE user_id = :user_id AND prompt_id = :prompt_id");
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':prompt_id', $promptId, PDO::PARAM_INT);
            $stmt->execute();
            $likes = $stmt->fetchColumn();
    
            return $likes;
    
        } catch (PDOException $e) {
            echo "Error getting likes: " . $e->getMessage();
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['prompt_id'], $_POST['user_id'])) {
    $promptId = $_POST['prompt_id'];
    $userId = $_POST['user_id'];

    $like = new like();
    $like->toggleLike($promptId, $userId);
}
