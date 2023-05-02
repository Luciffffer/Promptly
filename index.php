<?php 

    session_start();
    include_once(__DIR__ . "/classes/User.php");
    include_once(__DIR__ . "/classes/Prompt.php");
    
    usort($sorting, ['Prompt', 'compareByTitle']);
    var_dump($sorting);

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Promptly</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="shortcut icon" href="assets/images/site/promptly-logo.svg" type="image/x-icon">
</head>
<body>
    <?php include_once(__DIR__ . "/partials/nav.inc.php"); ?>
    <div>

    </div>
</body>
</html>