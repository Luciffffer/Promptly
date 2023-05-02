<?php

include_once(__DIR__ . "/../classes/User.php");

if (!empty($_POST)) {
    try {
        $available = User::checkUnique($_POST['columnName'], $_POST['columnValue']);

        $response = [
            "status" => "success",
            "available" => $available 
        ];
    } catch (Throwable $err) {
        http_response_code(500);

        $response = [
            "status" => "error",
            "message" => $err->getMessage()
        ];
    }

    header("Content-Type: application/json");
    echo json_encode($response);
}

exit();