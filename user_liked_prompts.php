<?php 

include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/Prompt.php");
include_once(__DIR__ . "/classes/Like.php");
include_once(__DIR__ . "/classes/Database.php");

session_start();

try {
    if (!empty($_GET['id'])) {
        $user = User::getUserById($_GET['id']);
    } 
} catch (Throwable $err) {
    header("location: index");
}
if (!empty($_GET['order'])) {
    $order = $_GET['order'];
} else {
    $order = '';
}


$prompt = new Prompt();
$prompts = $prompt->getPrompts($order, approved: 1);


?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liked Prompts - Promptly</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="shortcut icon" href="assets/images/site/promptly-logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/platform.css">
</head>
<body>
    <?php include_once(__DIR__ . "/partials/nav.inc.php"); ?>
    <main>
        <?php include_once(__DIR__ . "/partials/aside.inc.php"); ?>
    </main>
    <section aria-label="Prompt list" id="all-prompts-list">
                <?php //var_dump($prompts); ?>
                <?php foreach ($prompts as $prompt) : ?>

                    <?php 
                        $promptTags = json_decode($prompt['tags'], true);  
                    ?>
                    <div>
                        <a href="prompt?id=<?php echo $prompt['id']; ?>" class="prompt-card-header" style="background-image: url(<?php echo $prompt['header_image']; ?>)">
                            <div class="prompt-card-header-model">

                            </div>
                        </a>
                        <div class="prompt-card-body">
                            <div class="prompt-card-body-left">
                                <a class="white-a" href="prompt?id=<?php echo $prompt['id']; ?>"><?php echo htmlspecialchars($prompt['title']); ?></a>
                                <small class="prompt-card-tags">
                                    <?php for ($i = 0; $i < 4 && isset($promptTags[$i]); ++$i) : ?>
                                        <span><?php echo htmlspecialchars($promptTags[$i]); ?></span>
                                    <?php endfor; ?>
                                </small>
                            </div>
                            <a href="#" class="button prompt-card-get-btn">
                                <img src="assets/images/site/plus-circle-icon.svg" alt="Get Prompt">
                            </a>
                        </div>
                    </div>

                <?php endforeach; ?>
            </section>
</body>
</html>