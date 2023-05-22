<?php 

include_once(__DIR__ . "/../classes/Prompt.php");
include_once(__DIR__ . "/../classes/Database.php");
include_once(__DIR__ . "/../classes/Notification.php");

session_start();

if (isset($_SESSION['isModerator']) && $_SESSION['isModerator'] === true)
{
    $prompt = Prompt::getPromptById($_POST['id']);
    $notif = new Notification();
    $notif->setMessage("Your prompt " . $prompt['title'] . " has been denied!");
    $notif->setUserId($prompt['author_id']);

    $prompt = new Prompt();
    $prompt->setId($_POST['id']);
    $prompt->deletePrompt($_POST['id']);

    $response = [
        'status' => 'success',
        'message' => 'Prompt deleted'
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



header('Content-Type: application/json');
echo json_encode($response);
