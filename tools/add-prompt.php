<?php 

include_once(__DIR__ . "/../classes/Security.php");

Security::onlyLoggedIn();

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a Prompt - Promptly</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="shortcut icon" href="../assets/images/site/promptly-logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="../css/platform.css">
    <script src="../assets/js/add-prompt-images.js" defer></script>
</head>
<body>
    <?php include_once(__DIR__ . "/../partials/nav.inc.php"); ?>
    <main>
        <?php include_once(__DIR__ . "/../partials/aside.inc.php"); ?>
        <div>
            <label for="prompt-header-image">
                <header id="prompt-header">
                    <div class="hidden"></div>
                    <i></i>
                </header>
            </label>
            <input type="file" name="prompt-header-image" id="prompt-header-image" accept=".jpg, .jpeg, .png, .webp" class="hidden">
        </div>
    </main>
</body>
</html>