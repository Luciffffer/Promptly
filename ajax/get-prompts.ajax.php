<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use Promptly\Core\Prompt;

try {
    $prompt = new Prompt();

    if (!empty($_GET['free']) && $_GET['free'] == 1) {
        $prompt->setIsFree(true);
    }

    if (!empty($_GET['order'])) {
        $order = $_GET['order'];
    } else {
        $order = "";
    }

    if (!empty($_GET['search'])) {
        $search = $_GET['search'];
    } else {
        $search = '';
    }

    if (!empty($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = null;
    }

    if (!empty($_GET['categories'])) {
        $categories = '[' . $_GET['categories'] . ']';
        $prompt->setCategories($categories);
    }

    if (!empty($_GET['models'])) {
        $models = '[' . $_GET['models'] . ']';
        $prompt->setModels($models);
    }

    $prompts = $prompt->getPrompts($order, $page, 1, search: $search);

    // attach model information to prompts
    foreach($prompts as $key => $prompt) {
        $model = Prompt::getModelById($prompt['model_id']);
        $prompts[$key]['model'] = $model;
    }

    $response = [
        "status" => "success",
        "prompts" => $prompts,
        "page" => $page
    ];

} catch (Throwable $err) {
    $response = [
        "status" => "error",
        "message" => $err->getMessage()
    ];
}

header('Content-Type: application/json');
echo json_encode($response);
exit();