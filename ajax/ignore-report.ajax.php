<?php 

include_once(__DIR__ . "/../classes/Report.php");

session_start();

try{
    if(isset($_SESSION['isModerator']) && $_SESSION['isModerator'] === true){

        $report = new Report();
        $report->setId($_POST['id']);
        $report->removeReport($_POST['id']);

        $response = [
            'status' => 'success',
            'message' => 'User rapportation ignored'
        ];
    } else {
        $response = [
            'status' => 'error',
            'message' => 'You are not authorized to do this'
        ];
    }
} catch (Throwable $err) {
    $response = [
        'status' => 'error',
        'message' => $err->getMessage()
    ];
}


header('Content-Type: application/json');
echo json_encode($response);