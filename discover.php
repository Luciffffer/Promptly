<?php

require_once(__DIR__ . '/vendor/autoload.php');

use Promptly\Core\Prompt;

session_start();

$prompt = new Prompt();
$popularPrompts = $prompt->getPrompts(order: "popular", approved: 1, limit: 10);
$newPrompts = $prompt->getPrompts(order: "new", approved: 1, limit: 10);

$categories = Prompt::getAllCategories();
$models = Prompt::getAllModels();

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

                <form action="all-prompts" id="discover-filter-form">
                    <div id="filter-btn-container" style="justify-content: center;">
                        <a data-filterBtn="models" href="#" class="filter-btn button">
                            <h3>Models</h3>
                            <img src="assets/images/site/arrow-right.svg" alt="Arrow right">
                        </a>
                        <a data-filterBtn="categories" href="#" class="filter-btn button">
                            <h3>Categories</h3>
                            <img src="assets/images/site/arrow-right.svg" alt="Arrow right">
                        </a>
                        <a data-free-btn href="all-prompts?order=popular&free=1" class="filter-btn button">
                            <h3>Free</h3>
                            <img src="assets/images/site/arrow-right.svg" alt="Arrow right">
                        </a>
                        <input data-input="categories" class="hidden" type="text" name="categories"></input>
                        <input data-input="models" class="hidden" type="text" name="models"></input>
                        <input data-input="free" class="hidden" type="text" name="free"></input>
                    </div>

                    <div data-filterDropdown="categories" class="filter-dropdown filter-dropdown-hidden hidden">
                        <div class="filter-dropdown-grid">
                            <?php foreach($categories as $category) : ?>
                                <span data-id="<?php echo $category['id']; ?>">
                                    <?php echo $category['title']; ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                        <input class="primary-btn-white button" type="submit" value="Apply filters">
                    </div>
                    <div data-filterDropdown="models" class="filter-dropdown filter-dropdown-hidden hidden">
                        <div class="filter-dropdown-grid">
                            <?php foreach($models as $model) : ?>
                                <span data-id="<?php echo $model['id']; ?>">
                                    <?php echo $model['name']; ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                        <input class="primary-btn-white button" type="submit" value="Apply filters">
                    </div>
                </form>

                <figure class="discover-header-rect" id="discover-header-rect-1"></figure>
                <figure class="discover-header-rect" id="discover-header-rect-2"></figure>

                <script>
                    // These filter buttons are such a horrendous monstrosity that i've made.
                    // If i ever work on this project again, I'm gonna redo this whole thing.
                    // At least i've learned a lot about drop downs. The further along the project, the better the dropdowns got.

                    // check children of filter dropdowns
                    document.querySelectorAll(".filter-dropdown-grid").forEach(dropdownGrid => {
                        dropdownGrid.addEventListener("click", e => {
                            if (e.target !== e.currentTarget) {
                                e.target.classList.toggle("filter-dropdown-checked");
                                setInputValues();
                            }
                        });
                    });

                    // set input values
                    function setInputValues() {
                        const categoriesInput = document.querySelector("[data-input='categories']");
                        const modelsInput = document.querySelector("[data-input='models']");
                        const categoriesChecked = document.querySelectorAll("[data-filterDropdown='categories'] .filter-dropdown-checked");
                        const modelsChecked = document.querySelectorAll("[data-filterDropdown='models'] .filter-dropdown-checked");
                        let categoriesValue = "";
                        let modelsValue = "";

                        categoriesChecked.forEach((category, i) => {
                            categoriesValue += category.dataset.id;
                            if (i < categoriesChecked.length - 1) categoriesValue += ",";
                        });
                        modelsChecked.forEach((model, i) => {
                            modelsValue += model.dataset.id;
                            if (i < modelsChecked.length - 1) modelsValue += ",";
                        });

                        categoriesInput.value = categoriesValue;
                        modelsInput.value = modelsValue;
                    }

                    // show/hide dropdowns
                    document.querySelector("#filter-btn-container").addEventListener("click", e => {
                        if (e.target.dataset.filterbtn !== undefined) {
                            e.preventDefault();
                            const dropdown = document.querySelector(`[data-filterDropdown="${e.target.dataset.filterbtn}"]`);
                            const input = document.querySelector(`[data-input="${e.target.dataset.filterbtn}"]`);
                            const arrow = e.target.querySelector(`[data-filterBtn="${e.target.dataset.filterbtn}"] > img`);

                            if (dropdown.classList.contains("filter-dropdown-hidden")) {

                                dropdown.classList.remove("hidden");
                                setTimeout(() => {
                                    dropdown.classList.remove("filter-dropdown-hidden");
                                }, 20);
                                arrow.classList.add("filter-btn-open");

                            } else {

                                dropdown.classList.add("filter-dropdown-hidden");
                                dropdown.addEventListener("transitionend", function() {
                                    dropdown.classList.add("hidden");
                                }, {
                                    once: true
                                });
                                arrow.classList.remove("filter-btn-open");

                            }
                        }
                    });

                    document.querySelector("[data-free-btn]").addEventListener('click', e => {
                        e.preventDefault();

                        document.querySelector("[data-input='free']").value = 1;
                        document.querySelector("#discover-filter-form").submit();
                    });
                </script>
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
                                        <a href="prompt?id=<?php echo $prompt['id']; ?>" class="button prompt-card-arrow">
                                            <img src="assets/images/site/arrow-right.svg" alt="Arrow">
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
                                        <a href="prompt?id=<?php echo $prompt['id']; ?>" class="button prompt-card-arrow">
                                            <img src="assets/images/site/arrow-right.svg" alt="Arrow">
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
            <section class="center-parent">
                <div class="center" id="top-users">
                    <?php
                        $topUsers = Promptly\Core\User::getUserIdsWithMostSales();
                    ?>
                    <h2>Top Users of The Week 🔥</h2>
                    <p>Users with the most prompts sold this week.</p>
                    <div id="top-users-card-container">
                        <?php foreach($topUsers as $key => $topUser) : ?>

                            <?php $user = \Promptly\Core\User::getUserById($topUser['id']); ?>
                            
                            <div class="top-user-card">
                                <span class="top-user-card-number">#<?php echo $key + 1; ?></span>
                                <a class="white-a" href="profile?id=<?php echo $user['id']; ?>">
                                    <div class="top-user-card-pic-outer">
                                        <div class="top-user-card-pic-inner">
                                            <figure class="top-user-card-profile-pic" style="background-image: url(<?php echo $user['profile_pic']; ?>);"></figure>
                                        </div>
                                    </div>
                                    <h3><?php echo htmlspecialchars($user['username']); ?></h3>
                                </a>
                                <p><span class="blue-text"><?php echo $topUser['sales']; ?> prompts</span> sold</p>
                                <div>
                                    <a class="top-user-btn button" href="profile?id=<?php echo $user['id']; ?>">View Profile</a>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
            <section class="center-parent" style="display: flex; justify-content: center; margin-bottom: 3rem">
                <div class="center">
                    <a href="all-prompts?order=popular" class="discover-end-btn button">View all prompts</a>
                </div>
            </section>
        </div>
    <main>
</body>
</html>