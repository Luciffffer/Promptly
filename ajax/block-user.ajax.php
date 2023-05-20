<?php 

include_once(__DIR__ . "/../classes/Report.php");
include_once(__DIR__ . "/../classes/User.php");
include_once(__DIR__ . "/../classes/Database.php");
include_once(__DIR__ . "/../classes/Notification.php");

session_start();

try{
    if(isset($_SESSION['isModerator']) && $_SESSION['isModerator'] === true){
        $notif = new Notification();
        $notif->setMessage("You have been blocked!");
        $notif->setUserId($_POST['id']);

        $user = new User();
        $user->setId($_POST['id']);
        $user->blockUser($_POST['id']);

        $report = new Report();
        $report->setUser_id($_POST['id']);
        $report->removeReport($_POST['id']);

        $response = [
            'status' => 'success',
            'message' => 'User blocked'
        ];

        $notif->setLink("index.php");
        $notif->setImage("assets/images/site/denied.svg");
        $notif->save();
    } else {
        $response = [
            'status' => 'error',
            'message' => 'You are not authorized to do this'
        ];
    }
} catch (Throwable $err) {
    $response = [
        'status' => 'error',
        'message' => $err->getMessage()
    ];
}


header('Content-Type: application/json');
echo json_encode($response);