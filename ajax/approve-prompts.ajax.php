<?php

require_once(__DIR__ . "/../vendor/autoload.php");

use Promptly\Core\Prompt;
use Promptly\Core\Notification;
use Promptly\Core\User;

session_start();


// Zegher if you have time please put this stuff in a try catch and return the error message
if (isset($_SESSION['isModerator']) && $_SESSION['isModerator'] === true) {
    $prompt = new Prompt();
    $prompt->setId($_POST['id']);
    $prompt->approvePrompt();

    $response = [
        'status' => 'success',
        'message' => 'Prompt approved'
    ];

    $prompt = Prompt::getPromptById($_POST['id']);

    $notif = new Notification();
    $notif->setMessage("Your prompt " . $prompt['title'] . " has been approved!");
    $notif->setUserId($prompt['author_id']);
    $notif->setLink("prompt.php?id=" . $_POST['id']);
    $notif->setImage("assets/images/site/approved.svg");
    $notif->save();

    // verify user
    $newPrompt = new Prompt();
    $newPrompt->setAuthorId($prompt['author_id']);
    $UserPrompts = $newPrompt->getPrompts(approved: 1, limit: 4);
    if (count($UserPrompts) === 3 && User::getUserById($prompt['author_id'])['verified'] != 1) {
        User::verifyUser($prompt['author_id']);

        $notification = new Notification();
        $notification->setMessage("You have been verified! 3 of your prompts have been approved!");
        $notification->setUserId($prompt['author_id']);
        $notification->setLink("profile.php?id=" . $prompt['author_id']);
        $notification->setImage("assets/images/site/verified-notification-icon.svg");
        $notification->save();
    }       

} else {
    $response = [
        'status' => 'error',
        'message' => 'You are not authorized to do this'
    ];
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
