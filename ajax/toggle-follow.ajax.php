<?php

include_once(__DIR__ . '/../classes/Follow.php');

session_start();

try {

    if (isset($_SESSION['userId']) && isset($_POST['followeeId']) && $_SESSION['userId'] != $_POST['followeeId']) {
        
        $follow = new Follow();
        $follow->setFolloweeId($_POST['followeeId']);
        $follow->setFollowerId($_SESSION['userId']);
        $followed = $follow->toggleFollow();

        $response = [
            'status' => 'success',
            'message' => $followed,
            'followers' => Follow::getFollowerCount($_POST['followeeId'])
        ];

    } else {
        throw new Exception("You must be logged in and provide a followeeId to follow a user. Also can't follow yourself.");
    }

} catch (Throwable $err) {
    $response = [
        'status' => 'error',
        'message' => $err->getMessage()
    ];
}

header('Content-Type: application/json');
echo json_encode($response);
exit();