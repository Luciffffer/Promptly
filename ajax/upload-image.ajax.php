<?php

include_once(__DIR__ . "/../classes/File.php");

if (!empty($_FILES['image'])) {
    try {

        $image = new File();
        $image->setImageName($_FILES['image']['name']);
        $image->validateImageSize($_FILES['image']['size']);
        move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . "/../assets/images/user-submit/" . $image->getName());

        $response = [
            'status' => 'success',
            'body' => 'assets/images/user-submit/' . $image->getName(),
            'message' => 'Image has been successfully added'
        ];

    } catch (Throwable $err) {
        $response = [
            'status' => 'error',
            'message' => $err->getMessage()
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}
