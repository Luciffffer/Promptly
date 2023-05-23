<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use Promptly\Core\Prompt;

if (!empty($_POST['modelId'])) {
    $versions = prompt::getModelVersions($_POST['modelId']);
    
    $response = [
        "status" => "success",
        "body" => $versions
    ];

    header("Content-Type: application/json");
    echo json_encode($response);
}

exit();