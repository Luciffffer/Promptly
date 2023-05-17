<?php

include_once(__DIR__ . "/../classes/Comment.php");

session_start();

try {

    if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) {

        if (empty($_POST['commentId'])) {
            throw new Exception("Comment id is required");
        }

        $comment = Comment::getCommentById($_POST['commentId']);
        
        if ($comment['user_id'] !== $_SESSION['userId'] && !isset($_SESSION['isModerator'])) {
            throw new Exception("You can only remove your own comments. Except if you are a moderator");
        }

        Comment::removeComment($_POST['commentId']);
        $comments = Comment::getAllCommentsInformationForDisplay($comment['prompt_id']);

        $response = [
            "status" => "success",
            "comments" => $comments,
            "message" => "Comment removed"
        ];

    } else {
        throw new Exception("You must be logged in to remove a comment");
    }

} catch (Throwable $err) {
    $response = [
        "status" => "error",
        "message" => $err->getMessage()
    ];
}

header('Content-Type: application/json');
echo json_encode($response);
exit();