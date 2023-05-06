<?php

include_once(__DIR__ . "/../classes/Prompt.php");

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