<?php

include_once(__DIR__ . "/../classes/Notification.php");

session_start();

try {

    if (isset($_SESSION['userId'])) {

        $notifications = Notification::getNotificationsByUserId($_SESSION['userId']);
        Notification::setViewedByUserId($_SESSION['userId']);

        $response = [
            'status' => 'success',
            'body' => $notifications
        ];

    } else {
        throw new Exception("User not logged in");
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
