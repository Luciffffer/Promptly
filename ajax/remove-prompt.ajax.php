<?php 

include_once(__DIR__ . "/../classes/Prompt.php");
include_once(__DIR__ . "/../classes/Database.php");

if (isset($_SESSION['isModerator']) && $_SESSION['isModerator'] === true)
{
    $prompt = new Prompt();
    $prompt->setId($_POST['id']);
    $prompt->deletePrompt($_POST['id']);

    $response = [
        'status' => 'success',
        'message' => 'Prompt deleted'
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    header('Location: ../index.php');
}
