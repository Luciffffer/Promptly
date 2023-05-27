<?php

require_once(__DIR__ . "/../vendor/autoload.php");

try {

    $prompt = new Promptly\Core\Prompt();
    $prompts = $prompt->getPrompts(approved: 1, limit: 40, order: 'new');

    $prompts = array_map(function ($prompt) {
        return [
            'id' => $prompt['id'],
            'promptTitle' => $prompt['title'],
            'promptLink' => 'http://' . $_SERVER['HTTP_HOST'] . __ROOT__ . 'prompt.php?id=' . $prompt['id'],
            'promptDateAdded' => $prompt['date_created'],
            'promptHeaderImage' => 'http://' . $_SERVER['HTTP_HOST'] . __ROOT__ . $prompt['header_image'],
            'promptExampleImage1' => 'http://' . $_SERVER['HTTP_HOST'] . __ROOT__ . $prompt['example_image1'],
            'promptExampleImage2' => $prompt['example_image2'] ? 'http://' . $_SERVER['HTTP_HOST'] . __ROOT__ . $prompt['example_image2'] : null,
            'promptExampleImage3' => $prompt['example_image3'] ? 'http://' . $_SERVER['HTTP_HOST'] . __ROOT__ . $prompt['example_image3'] : null,
            'promptExampleImage4' => $prompt['example_image4'] ? 'http://' . $_SERVER['HTTP_HOST'] . __ROOT__ . $prompt['example_image4'] : null,
        ];
    }, $prompts);

    $response = [
        'status' => 'success',
        'data' => [
            'prompts' => $prompts
        ]
    ];

} catch (Throwable $err) {
    $response = ([
        'status' => 'error',
        'message' => $err->getMessage()
    ]);
}

header('Content-Type: application/json');
echo json_encode($response);
