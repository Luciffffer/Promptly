<?php

require_once(__DIR__ . "/../vendor/autoload.php");

session_start();

try {

    if (isset($_SESSION['userId']) && isset($_POST['promptId'])) {

        $creditPrice = 1;

        // check if user already owns prompt
        if (Promptly\Core\Sale::saleExists($_SESSION['userId'], $_POST['promptId'])) {
            throw new Exception('You already own this prompt.');
        }

        $prompt = Promptly\Core\Prompt::getPromptById($_POST['promptId']);
        if ($prompt['free'] == 0) {
            
            // credits
            $credits = Promptly\Core\User::getCreditsByUserId($_SESSION['userId']);
            if ($credits < $creditPrice) {
                throw new Exception('You do not have enough credits to purchase this prompt.');
            }

            // update user credits
            $credits -= $creditPrice;
            $user = new Promptly\Core\User();
            $user->setId($_SESSION['userId']);
            $user->setCredits($credits);
            $user->updateUser();

            // update author credits
            $authorId = $prompt['author_id'];
            $authorCredits = Promptly\Core\User::getCreditsByUserId($authorId);
            $authorCredits += $creditPrice;
            $authorUser = new Promptly\Core\User();
            $authorUser->setId($authorId);
            $authorUser->setCredits($authorCredits);
            $authorUser->updateUser();

            // send notivication to author
            $notification = new Promptly\Core\Notification();
            $notification->setMessage("Someone bought your prompt: " . $prompt['title'] . "! You have earned " . $creditPrice . " credit.");
            $notification->setUserId($authorId);
            $notification->setLink("prompt?id=" . $prompt['id']);
            $notification->setImage('assets/images/site/money-notification-cover.svg');
            $notification->save();

        }

        // create sale
        $sale = new Promptly\Core\Sale();
        $sale->setUserId($_SESSION['userId']);
        $sale->setPromptId($_POST['promptId']);
        $sale->save();

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
