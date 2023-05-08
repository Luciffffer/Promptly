<?php 

include_once(__DIR__ . '/classes/Prompt.php');

session_start();

if (!empty($_GET['id'])) {
    $prompt = Prompt::getPromptById($_GET['id']);
    Prompt::addView($_GET['id']);
} else {
    header("Location: index");
    exit();
}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $prompt['title'] ?> - Promptly</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="shortcut icon" href="assets/images/site/promptly-logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/platform.css">
    <link rel="stylesheet" href="css/single-prompt.css">
</head>
<body>
    <?php include_once(__DIR__ . "/partials/nav.inc.php"); ?>
    <main>
        <?php include_once(__DIR__ . "/partials/aside.inc.php"); ?>
        <header id="prompt-header" style="background-image: url(<?php echo $prompt['header_image'] ?>)">
            <div></div>
        </header>
        <script src="assets/js/prompt-header-parallax.js" defer></script>
        <div class="center-parent">
            <div class="center" id="single-prompt-grid">
            </div>
        </div>
    </main>
</body>
</html>