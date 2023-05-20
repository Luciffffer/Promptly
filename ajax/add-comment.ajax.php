<?php

include_once(__DIR__ . "/../classes/Comment.php");
include_once(__DIR__ . "/../classes/User.php");

session_start();

$user = User::getUserById($_SESSION['userId']);

try {

    if (isset($_SESSION['userId']) && $user['blocked'] == 0) {
    
        if (empty($_POST['promptId']) || empty($_POST['comment']) && $user['blocked'] = 0) {
            throw new Exception('Prompt id and comment is required');
        }

        $comment = new Comment();
        $comment->setPromptId($_POST['promptId']);
        $comment->setUserId($_SESSION['userId']);
        $comment->setComment($_POST['comment']);

        $comment->saveComment();

        $comments = Comment::getAllCommentsInformationForDisplay($_POST['promptId']);

        $response = [
            "status" => "success",
            "comments" => $comments
        ];

    } else {
        throw new Exception('You must be logged in to add a comment');
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