<?php

include_once(__DIR__ . "/classes/Security.php");

Security::onlyLoggedIn();

if (!empty($_GET['page'])) {

    switch ($_GET['page']) {
        case "bought":
            $page = "bought";
            break;
        case "liked":
            $page = "liked";
            break;
        case "yours":
            $page = "yours";
            break;
        default:
            $page = "liked";
            break;
    }

} else {
    $page = 'liked';
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
        </div>
    </main>
</body>
</html>