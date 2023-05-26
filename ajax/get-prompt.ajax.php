<?php

require_once(__DIR__ . "/../vendor/autoload.php");

session_start();

try {

    if (isset($_SESSION['userId']) && isset($_POST['promptId'])) {

        // check user credits
        $credits = Promptly\Core\User::getCreditsByUserId($_SESSION['userId']);
        if ($credits < 1) {
            throw new Exception('You do not have enough credits to purchase this prompt.');
        }

        // check if user already owns prompt
        if (Promptly\Core\Sale::saleExists($_SESSION['userId'], $_POST['promptId'])) {
            throw new Exception('You already own this prompt.');
        }

        // create sale
        $sale = new Promptly\Core\Sale();
        $sale->setUserId($_SESSION['userId']);
        $sale->setPromptId($_POST['promptId']);
        $sale->save();

        // update user credits
        $credits--;
        $user = new Promptly\Core\User();
        $user->setId($_SESSION['userId']);
        $user->setCredits($credits);
        $user->updateUser();

        $response = ([
            'status' => 'success',
            'message' => 'Prompt purchased successfully.'
        ]);

    } else {
        throw new Exception('You must be logged in and provide a prompt id to purchase a prompt.');
    }

} catch (Throwable $err) {
    $response = ([
        'status' => 'error',
        'message' => $err->getMessage()
    ]);
}

header('Content-Type: application/json');
echo json_encode($response);
exit();