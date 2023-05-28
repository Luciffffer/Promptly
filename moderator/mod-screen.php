<?php
require_once(__DIR__ . "/../vendor/autoload.php");

use Promptly\Core\Prompt;
use Promptly\Core\User;
use Promptly\Helpers\Security;

// include_once("../ajax/remove-prompt.ajax.php"); 
Security::onlyModerator();

$prompt = new Prompt();
$prompts = $prompt->getPrompts(approved: 0);


?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderator Screen</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="shortcut icon" href="../assets/images/site/promptly-logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="../css/platform.css">
    <link rel="stylesheet" href="../moderator/moderator.css">
</head>
<body>
<?php include_once(__DIR__ . "/../partials/nav.inc.php"); ?>
    <main>
        <?php include_once(__DIR__."/../partials/aside.inc.php");?>

        <div id="header-title">
            <h1>Moderation Tool</h1>
        </div>

        <div id="grid-mod-tools">
            <div id="apr-prompts">
                <a href="approve-prompts.php"><p>Approve prompts</p></a>
            </div>
            <div id="rep-user">
                <a href="reported-users.php"><p>Reported users</p></a>
            </div>
            <div id="blocked">
                <a href="blocked-users.php"><p>Blocked Users</p></a>
            </div>
            <div id="rem">
                <a href="remove-mod.php"><p>Remove MODS</p></a>
            </div>
        </div>
    </main>
</body>
</html>