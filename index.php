<?php 

    session_start();

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Promptly</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="shortcut icon" href="assets/images/site/promptly-logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/home-page.css">
</head>
<body>
    <header>
        <?php include_once(__DIR__ . '/partials/nav.inc.php'); ?>
        <section id="home-hero-section">
            <h1>This is <span class="blue-text">Promptly</span></h1>
            <p>A platform where you can find, sell, and get prompts quickly.<br>Check out the 2 most popular prompts of the day below!</p>
            <div id="home-hero-cards">
                <div></div>
                <div></div>
            </div>
        </section>
    </header>
</body>
</html>