<?php

include_once(__DIR__ . "/../classes/Like.php");


try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['prompt_id'], $_POST['user_id'])) {
        $promptId = $_POST['prompt_id'];
        $userId = $_POST['user_id'];
    
        $like = new like();
        $like->toggleLike($promptId, $userId);
    }
} catch (Throwable $e) {
    echo "Error getting likes: " . $e->getMessage();
}

exit();