<?php

require_once(__DIR__ . '/vendor/autoload.php');

use Promptly\Core\Prompt;

session_start();

$prompt = new Prompt();
$popularPrompts = $prompt->getPrompts(order: "popular", approved: 1, limit: 10);
$newPrompts = $prompt->getPrompts(order: "new", approved: 1, limit: 10);

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discover - Promptly</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="shortcut icon" href="assets/images/site/promptly-logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/platform.css">
    <link rel="stylesheet" href="css/discover.css">
    <script src="assets/js/discover-horizontal-scroll.js" defer></script>
</head>
<body>
    <?php include_once(__DIR__ . "/partials/nav.inc.php"); ?>
    <main>
        <?php include_once(__DIR__ . "/partials/aside.inc.php"); ?>
        <div style="width: 100%;">
            <header id="discover-header">
                <h1><span id="discover-text">Discover</span> Prompts</h1>
                <p>Discover what promptly has to offer. From the most popular prompts to niche specific prompts.</p>
                <div id="filter-btn-container">
                    <a data-filterBtn="models" href="#" class="filter-btn button">
                        <h3>Models</h3>
                        <img src="assets/images/site/arrow-right.svg" alt="Arrow right">
                    </a>
                    <a data-filterBtn="categories" href="#" class="filter-btn button">
                        <h3>Categories</h3>
                        <img src="assets/images/site/arrow-right.svg" alt="Arrow right">
                    </a>
                    <a href="all-prompts?free=1" class="filter-btn button">
                        <h3>Free</h3>
                        <img src="assets/images/site/arrow-right.svg" alt="Arrow right">
                    </a>
                    <input data-input="categories" class="hidden" type="text" name="categories"></input>
                    <input data-input="models" class="hidden" type="text" name="models"></input>
                </div>
                <figure class="discover-header-rect" id="discover-header-rect-1"></figure>
                <figure class="discover-header-rect" id="discover-header-rect-2"></figure>
            </header>
            <div class="discover-lines">
                <section class="discover-prompts-list-section">
                    <a class="center-parent white-a discover-prompts-top" href="all-prompts.php?order=popular">
                        <h3>Popular Prompts</h3>
                        <span class="discover-prompts-top-right">
                            <span class="discover-prompts-top-hide">View all popular promps</span>
                            <span class="arrow">&#8594;</span>
                        </span>
                    </a>
                    <div class="hor-scroll-container">

                        <figure data-scroll="left" display="hidden">
                            <img src="assets/images/site/arrow-left-white.svg" alt="Arrow left">
                        </figure>

                        <div class="discover-prompts-list">

                            <?php foreach ($popularPrompts as $prompt) : ?>

                                <?php 
                                    $promptTags = json_decode($prompt['tags'], true);  
                                    $promptModel = Prompt::GetModelById($prompt['model_id']);
                                ?>
                                <div>
                                    <a href="prompt?id=<?php echo $prompt['id']; ?>" class="prompt-card-header" style="background-image: url(<?php echo $prompt['header_image']; ?>)">
                                        <div class="prompt-card-header-model">
                                            <img src="<?php echo $promptModel['icon']; ?>" alt="<?php echo $promptModel['name']; ?>">
                                            <span><?php echo $promptModel['name']; ?></span>
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

                        </div>

                        <figure data-scroll="right">
                            <img src="assets/images/site/arrow-right.svg" alt="Arrow right">
                        </figure>

                    </div>
                </section>
                <section class="discover-prompts-list-section">
                    <a class="center-parent white-a discover-prompts-top" href="all-prompts.php?order=new">
                        <h3>New Prompts</h3>
                        <span class="discover-prompts-top-right">
                            <span class="discover-prompts-top-hide">View all new promps</span>
                            <span class="arrow">&#8594;</span>
                        </span>
                    </a>
                    <div class="hor-scroll-container">

                        <figure data-scroll="left" display="hidden">
                            <img src="assets/images/site/arrow-left-white.svg" alt="Arrow left">
                        </figure>

                        <div class="discover-prompts-list">

                            <?php foreach ($newPrompts as $prompt) : ?>

                                <?php 
                                    $promptTags = json_decode($prompt['tags'], true);  
                                    $promptModel = Prompt::GetModelById($prompt['model_id']);
                                ?>
                                <div>
                                    <a href="prompt?id=<?php echo $prompt['id']; ?>" class="prompt-card-header" style="background-image: url(<?php echo $prompt['header_image']; ?>)">
                                        <div class="prompt-card-header-model">
                                            <img src="<?php echo $promptModel['icon']; ?>" alt="<?php echo $promptModel['name']; ?>">
                                            <span><?php echo $promptModel['name']; ?></span>
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

                        </div>

                        <figure data-scroll="right">
                            <img src="assets/images/site/arrow-right.svg" alt="Arrow right">
                        </figure>

                    </div>
                </section>
            </div>
        </div>
    <main>
</body>
</html>