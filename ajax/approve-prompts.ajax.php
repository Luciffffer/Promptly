<?php

require_once(__DIR__ . "/../vendor/autoload.php");

use Promptly\Core\Prompt;
use Promptly\Core\Notification;

session_start();

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

} else {
    $response = [
        'status' => 'error',
        'message' => 'You are not authorized to do this'
    ];
}



header('Content-Type: application/json');
echo json_encode($response);
