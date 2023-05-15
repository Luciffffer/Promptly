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
            
            echo "success";
        } catch (PDOException $e) {
            echo "Error adding like: " . $e->getMessage();
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['prompt_id'], $_POST['user_id'])) {
    $promptId = $_POST['prompt_id'];
    $userId = $_POST['user_id'];

    $like = new like();
    $like->addLike($promptId, $userId);
}
