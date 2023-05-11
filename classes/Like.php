<?php
require_once(__DIR__ . "/Database.php");

class like
{
    public function addLike($promptId, $userId)
    {
        $pdo = Database::getInstance();

        try {
            $stmt = $pdo->prepare("INSERT INTO likes (prompt_id, user_id) VALUES (:prompt_id, :user_id)");
            $stmt->bindParam(':prompt_id', $promptId, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            
            return true;
        } catch (PDOException $e) {
            echo "Error adding like: " . $e->getMessage();
            return false;
        }
    }
}

$likes = new like();
$promptId = 1;
$userId = 1;

if ($likesManager->addLike($promptId, $userId)) {
    echo "Like added successfully!";
} else {
    echo "Failed to add like.";
}
