<?php

require_once(__DIR__ . "/vendor/autoload.php");

use Promptly\Core\Prompt;
use Promptly\Helpers\Security;

Security::onlyLoggedIn();

if (!empty($_GET['page'])) {

    switch ($_GET['page']) { // Should use infintie scroll for this. Not enough time rn
        case "bought":
            $page = "bought";
            $prompts = Prompt::getBoughtPromptsByUserId($_SESSION['userId']);
            break;
        case "liked":
            $page = "liked";
            $prompts = Prompt::getAllLikedPromptsByUserId($_SESSION['userId']);
            break;
        case "yours":
            $page = "yours";
            $prompt = new Prompt();
            $prompt->setAuthorId($_SESSION['userId']);
            $prompts = $prompt->getPrompts(order: 'new', limit: 40);
            break;
        default:
            $page = "liked";
            $prompts = Prompt::getAllLikedPromptsByUserId($_SESSION['userId']);
            break;
    }

} else {
    $page = 'liked';
    $prompts = Prompt::getAllLikedPromptsByUserId($_SESSION['userId']);
}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Library - Promptly</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="shortcut icon" href="assets/images/site/promptly-logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/platform.css">
</head>
<body>
    <?php include_once(__DIR__ . "/partials/nav.inc.php"); ?>
    <main>
        <?php include_once(__DIR__ . "/partials/aside.inc.php"); ?>
        <div>
            <header id="library-header">
                <h1>Your <span>Library</span></h1>
                <ul id="library-nav" aria-label="Your Library navigation">
                    <li>
                        <a class="white-a" href="library.php?page=bought">Bought Prompts</a>
                        <?php if ($page === 'bought') echo '<hr style="transform: translateX(0px);">'; ?>
                    </li>
                    <li>
                        <a class="white-a" href="library.php?page=liked">Liked Prompts</a>
                        <?php if ($page === 'liked') echo '<hr style="transform: translateX(0px);">'; ?>
                    </li>
                    <li>
                        <a class="white-a" href="library.php?page=yours">Your Prompts</a>
                        <?php if ($page === 'yours') echo '<hr style="transform: translateX(0px);">'; ?>
                    </li>
                </ul>
                <script>
                    // move the hr to the correct position animation
                    const listItems = document.querySelectorAll("#library-nav li > a");
                    const hr = document.querySelector("#library-nav li > hr");

                    listItems.forEach(listItem => {
                        listItem.addEventListener("click", e => {
                            const listItemX = e.currentTarget.parentNode.getBoundingClientRect().x;
                            const hrX = hr.getBoundingClientRect().x;

                            const diff = listItemX - hrX;
                            const currentTransform = hr.style.transform.match(/-?\d+/)[0];
                            const newTransform = parseInt(currentTransform) + diff;

                            hr.style.transform = `translateX(${newTransform}px)`;
                            hr.style.width = `${listItem.parentNode.clientWidth}px`;
                        })
                    })
                </script>
            </header>
            <div class="center-parent">
                <?php if (!empty($prompts)) : ?>

                    <?php if ($page === 'yours') : ?>
                        <section id="note-section">
                            <p>Prompts marked with a <span class="red-text">red border</span> haven't been approved yet!</p>
                        </section>
                    <?php endif; ?>

                    <section aria-label="Prompt list" id="all-prompts-list">
                        <?php foreach ($prompts as $prompt) : ?>

                            <?php 
                                $promptTags = json_decode($prompt['tags'], true);  
                                $promptModel = Prompt::GetModelById($prompt['model_id']);
                            ?>
                            <div>
                                <a href="prompt?id=<?php echo $prompt['id']; ?>" class="prompt-card-header <?php if (!$prompt['approved']) echo 'prompt-card-unapproved'; ?>" style="background-image: url(<?php echo $prompt['header_image']; ?>)">
                                    <div class="prompt-card-header-model">
                                        <?php if ($prompt['approved']) : ?>
                                            <img src="<?php echo $promptModel['icon']; ?>" alt="<?php echo $promptModel['name']; ?>">
                                            <span><?php echo $promptModel['name']; ?></span>
                                        <?php else : ?>
                                            <img src="assets/images/site/cross-symbol.svg" alt="Cross">
                                            <span class="red-text">Not Approved</span>
                                        <?php endif; ?>
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
                    </section>

                <?php else : ?>

                    <section aria-label="Prompt list">
                        <div id="no-prompts-container">
                            <?php if ($page === 'liked') : ?>
                                <h2>You haven't liked any prompts yet.</h2>
                                <p>Go to the <a href="discover.php">discover</a> page to find some prompts you like.</p>
                            <?php elseif ($page === 'bought') : ?>
                                <h2>You haven't bought any prompts yet</h2>
                            <?php elseif ($page === 'yours') : ?>
                                <h2>You haven't created any prompts yet</h2>
                                <p>Go to the <a href="tools/add-prompt.php">add prompt</a> page to create your own prompts.</p>
                            <?php endif; ?>
                        </div>
                    </section>

                <?php endif; ?>
            </div>
        </div>
    </main>
</body>
</html>