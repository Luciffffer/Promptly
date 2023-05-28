<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use \Promptly\Core\User;

session_start();

try {

    if (isset($_SESSION['userId'])) {

        $credits = User::getCreditsByUserId($_SESSION['userId']);
        $credits += 5;

        $user = new User();
        $user->setId($_SESSION['userId']);
        $user->setCredits($credits);
        $user->updateUser();

        $response = [
            'status' => 'success',
            'message' => '5 credits have been added to your account. Have fun testing!'
        ];

    } else {
        throw new Exception('You must be logged in to get credits');
    }

} catch (Throwable $err) {
    $respone = [
        'status' => 'error',
        'message' => $err->getMessage()
    ];
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
