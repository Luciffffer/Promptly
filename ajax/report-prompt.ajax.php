<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use \Promptly\Core\Report;

session_start();

try {

    if (isset($_SESSION['userId']) && !empty($_POST)) {

        $report = new Report();
        $report->setPromptId($_POST['promptId']);
        $report->setReason($_POST['reason']);
        $report->setReporterId($_SESSION['userId']);
        $report->setExtraInformation($_POST['extraInformation']);

        $report->saveReport();

        $response = [
            'status' => 'success',
            'message' => 'Report has been send and received'
        ];

    } else {
        throw new Exception('You must be logged in to report a prompt');
    }

} catch (Throwable $err) {
    $response = [
        'status' => 'error',
        'message' => $err->getMessage()
    ];
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
