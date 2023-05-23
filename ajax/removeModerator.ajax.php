<?php
require_once(__DIR__ . "/../vendor/autoload.php");

use \Promptly\Core\Notification;
use \Promptly\Core\Report;
use \Promptly\Core\User;

session_start();

try{
    if(isset($_SESSION['isModerator']) && $_SESSION['isModerator'] === true){

        $user = new User();
        $user->setId($_POST['id']);
        $user->removeMod($_POST['id']);

        $response = [
            'status' => 'success',
            'message' => 'Youve been removed as a moderator'
        ];

        $notif = new Notification();
        $notif->setMessage("A moderator has removed you as a moderator.");
        $notif->setUserId($_POST['id']);
        $notif->setLink("index.php");
        $notif->setImage("assets/images/site/denied.svg");
        $notif->save();
    } else {
        $response = [
            'status' => 'error removing mods - ajax',
            'message' => 'You are not authorized to do this'
        ];
    }
} catch (Throwable $err) {
    $response = [
        'status' => 'error extra - mod',
        'message' => $err->getMessage()
    ];
}


header('Content-Type: application/json');
echo json_encode($response);