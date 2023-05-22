<?php 

include_once(__DIR__ . "/../classes/Report.php");
include_once(__DIR__ . "/../classes/User.php");
include_once(__DIR__ . "/../classes/Notification.php");

session_start();

try{
    if(isset($_SESSION['isModerator']) && $_SESSION['isModerator'] === true){
        $oldReport = Report::getReportById($_POST['id']);

        $notif = new Notification();
        $notif->setMessage("A moderator has blocked your account for violating one of our rules! Please contact support if you think a mistake has been made.");
        $notif->setUserId($oldReport['user_id']);

        $user = new User();
        $user->setId($oldReport['user_id']);
        $user->blockUser($_POST['id']);

        $report = new Report();
        $report->setId($_POST['id']);
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