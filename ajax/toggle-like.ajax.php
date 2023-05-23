<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use Promptly\Core\Like;

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['prompt_id'], $_POST['user_id'])) { // don't send userId. Get it from the session
        $promptId = $_POST['prompt_id'];
        $userId = $_POST['user_id'];
    
        $like = new like();
        $like->toggleLike($promptId, $userId);
    }
} catch (Throwable $e) {
    echo "Error getting likes: " . $e->getMessage();
}

// no json send back. Just text send back. Json should be used for data
// a good response message would be like:
// 
// $response = [
//     'status' => 'success',
//     'message' => 'Like toggled successfully',
//     'likes' => $likeCount
// ];

exit();