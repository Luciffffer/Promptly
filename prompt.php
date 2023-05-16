<?php 

include_once(__DIR__ . '/classes/Prompt.php');
include_once(__DIR__ . '/classes/User.php');
include_once(__DIR__ . '/classes/Comment.php');
include_once(__DIR__ . '/classes/Date.php');

session_start();

if (!empty($_GET['id'])) {

    $prompt = Prompt::getPromptById($_GET['id']);

    $isAuthor = (isset($_SESSION['userId']) && $prompt['author_id'] == $_SESSION['userId']) ? true : false;

    if ($prompt['approved'] == 0 && !$isAuthor && !isset($_SESSION['isModerator'])) {
        Leave();
    }

    $model = Prompt::getModelById($prompt['model_id']);
    $categories = Prompt::getCategoriesByPromptId($_GET['id']);
    $author = User::getUserById($prompt['author_id']);
    $tags = json_decode($prompt['tags'], true);

    if (!$isAuthor) {
        Prompt::addView($_GET['id']);
    }

} else {
    Leave();
}

function Leave() {
    header("Location: index");
    exit();
}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($prompt['title']); ?> - Promptly</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="shortcut icon" href="assets/images/site/promptly-logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/platform.css">
    <link rel="stylesheet" href="css/single-prompt.css">
</head>
<body>
    <?php include_once(__DIR__ . "/partials/nav.inc.php"); ?>
    <main>
        <?php include_once(__DIR__ . "/partials/aside.inc.php"); ?>
        <div>
            <header id="prompt-header" style="background-image: url(<?php echo $prompt['header_image'] ?>); cursor: default;">
                <div></div>
            </header>
            <script src="assets/js/prompt-header-parallax.js" defer></script>
            <div class="center-parent">
                <div class="center" id="single-prompt-grid">
                    <div>
                        <section id="single-prompt-top">
                            <p id="single-prompt-top-left">
                                <span aria-label="Amount of people that bought the prompt">
                                    <img src="assets/images/site/plus-circle-icon.svg" alt="Buy icon">
                                    6
                                </span>
                                <span><?php echo htmlspecialchars($prompt['word_count']); ?> words</span>
                                <?php if ($prompt['approved']) : ?>
                                    <span>
                                        <img src="assets/images/site/success-icon.svg" alt="Check mark">
                                        Approved
                                    </span>
                                <?php else : ?>
                                    <span class="red-text">
                                        <img src="assets/images/site/cross-symbol.svg" alt="Cross">
                                        Not approved
                                    </span>
                                <?php endif; ?>
                            </p>
                            <div id="single-prompt-top-right">
                                <span>
                                    <img src="<?php echo $model['icon'] ?>" alt="Model icon">
                                    <?php echo $model['name']; ?>
                                </span>
                                <span>
                                    <?php echo $prompt['model_version']; ?>
                                </span>
                            </div>
                        </section>
                        <?php if (!$prompt['approved']) : ?>
                            <section id="single-prompt-approval">
                                <img src="./assets/images/site/warning-icon.svg" alt="Warning">
                                <p>
                                    This prompt is currently in the approval process. This means that it is not yet available to other users. You will get a notification as soon as your prompt has been approved or denied.
                                </p>
                            </section>
                        <?php endif; ?>
                        <hr class="single-prompt-hr">
                        <section id="single-prompt-basic-info">
                            <div>
                                <h1><?php echo htmlspecialchars($prompt['title']); ?></h1>
                                <p id="single-prompt-tags">
                                    <?php foreach($categories as $category) : ?>
                                        <a class="white-a" href="all-prompts?categories=<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['title']); ?></a>
                                    <?php endforeach; ?>
                                    <?php foreach($tags as $tag) : ?>
                                        <span><?php echo htmlspecialchars($tag); ?></span>
                                    <?php endforeach; ?>
                                </p>
                            </div>
                            <p><?php echo nl2br(htmlspecialchars($prompt['description'])); ?></p>
                        </section>
                        <?php if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] === false) : ?>
                            <section class="single-prompt-login-container">
                                <h2>Log in or sign up to see more!</h2>
                                <div>
                                    <a class="button primary-btn-white" id="primary-btn-nav" href="login">Log in</a>
                                    <a class="secondary-btn-white white-a" href="register">Sign up</a>
                                </div>
                            </section>
                        <?php else: ?>
                            <section id="single-prompt-action-section">
                                <div>
                                    <?php if ($prompt['free']) : ?>
                                        <a class="button" id="get-prompt-btn" href="#">
                                            <img src="assets/images/site/plus-circle-icon.svg" alt="Get icon">
                                            <span>Get prompt for free!</span>    
                                        </a>
                                    <?php else : ?>
                                        <?php if ($isAuthor || (isset($_SESSION['isModerator']) && $_SESSION['isModerator'] === true)) : ?>
                                            <div id="prompt-gotten-container">
                                                <img src="assets/images/site/success-icon.svg" alt="Checkmark">
                                                <span>You own this prompt!</span>
                                            </div>
                                        <?php else : ?>
                                            <a class="button" id="get-prompt-btn" href="#">
                                                <img src="assets/images/site/plus-circle-icon.svg" alt="Get icon">
                                                <span>Get prompt</span>
                                            </a>
                                            <small>It's only 1 credit!</small>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                                <div id="single-prompt-action-section-right">
                                    <a id="like-btn" href="#" aria-label="Like prompt"></a>
                                    <span>6</span>
                                    <hr>
                                    <a id="prompt-more-options-button" href="#" aria-label="More options"></a>
                                </div>
                            </section>
                            <section id="prompt-author-info">
                                <p class="grey">Created: <?php echo date("F jS, o", strtotime($prompt['date_created'])); ?></p>
                                <a class="white-a profile-a" href="profile?id=<?php echo $author['id']; ?>">
                                    <span class="grey">By:</span>
                                    <figure style="background-image: url(<?php echo $author['profile_pic'] ?>);"></figure>
                                    <span><?php echo htmlspecialchars($author['username']); ?></span>
                                </a>
                            </section>

                                <?php if ($isAuthor || isset($_SESSION['isModerator'])) : // if prompt has been bought or author is the same as session userid ?>

                                    <section id="prompt-section">
                                        <h2>The <span class="blue-text">Prompt:</span></h2>
                                        <div id="prompt-container">
                                            <p><?php echo nl2br(htmlspecialchars($prompt['prompt'])); ?></p>
                                        </div>
                                        <h3>Instructions</h3>
                                        <div id="prompt-container">
                                            <p><?php echo nl2br(htmlspecialchars($prompt['prompt_instructions'])); ?></p>
                                        </div>
                                    </section>

                                <?php else : ?>

                                    <section id="prompt-section">
                                        <h2>The <span class="blue-text">Prompt:</span></h2>
                                        <div id="prompt-container">
                                            <p>You didn't actually think you could hack the platform like this did you? Adipisci reiciendis ea sunt aspernatur suscipit, beatae dolorum minus accusantium, inventore dignissimos, quasi ullam harum velit numquam? Repellendus vero quis architecto et?</p>
                                            <div id="hide-prompt-overlay">
                                                <p>Get prompt to see</p>
                                            </div>
                                        </div>
                                        <h3>Instructions:</h3>
                                        <div id="prompt-container">
                                            <p>You didn't actually think you could hack the platform like this did you? Adipisci reiciendis ea sunt aspernatur suscipit, beatae dolorum minus accusantium, inventore dignissimos, quasi ullam harum velit numquam? Repellendus vero quis architecto et? Adipisci reiciendis ea</p>
                                            <div id="hide-prompt-overlay">
                                                <p>Get prompt to see</p>
                                            </div>
                                        </div>
                                    </section>

                                <?php endif; ?>


                            <section id="comment-section">
                                <h2>Comments</h2>

                                <form action="" id="add-comment-form">
                                    <figure style="background-image: url(<?php echo $_SESSION['profile-pic']; ?>)"></figure>
                                    <div>
                                        <textarea rows="1" name="comment" id="comment-textarea" placeholder="Add a comment..."></textarea>
                                        <div id="comment-buttons" class="hidden">
                                            <button class="button" id="comment-cancel">Cancel</button>
                                            <button class="button" id="comment-submit-btn">Post</button>
                                        </div>
                                    </div>
                                </form>
                                <script src="assets/js/comment-section.js" defer></script>

                                <div id="comment-list">
                                    <?php 
                                        $comments = Comment::getAllComments($prompt['id']);
                                    ?>

                                    <?php if (empty($comments)) : ?>
                                        <div id="no-comments-container">
                                            <p>No comments yet</p>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php foreach ($comments as $comment) : ?>

                                        <?php $commentUser = User::getUserById($comment['user_id']); ?>

                                        <div class="comment">
                                            <a href="profile?id=<?php echo $commentUser['id'] ?>">
                                                <figure style="background-image: url(<?php echo $commentUser['profile_pic'] ?>)"></figure>
                                            </a>
                                            <div>
                                                <div class="comment-top">
                                                    <a class="white-a" href="profile?id=<?php echo $commentUser['id'] ?>"><?php echo htmlspecialchars($commentUser['username']); ?></a>
                                                    <small><?php echo Date::getElapsedtime($comment['date_created']); ?></small>
                                                </div>
                                                <p><?php echo nl2br(htmlspecialchars($comment['comment'])); ?></p>
                                            </div>
                                            <?php if ((isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true && ($comment['user_id'] === $_SESSION['userId']) || isset($_SESSION['isModerator']))) : ?>
                                                <a href="#" class="delete-comment-btn" data-comment-id="<?php echo $comment['id']; ?>" aria-label="Delete comment"></a>
                                            <?php endif; ?>
                                        </div>

                                    <?php endforeach; ?>
                                </div>
                            </section>
                        <?php endif; ?>
                    </div>
                    <section id="single-prompt-image-container">
                        <figure style="background-image: url(<?php echo $prompt['example_image1']; ?>);" alt="Example image 1"></figure>
                        <?php if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] === false) : ?>
                            <figure class="single-prompt-login-container" style="aspect-ratio: 1/1; border-radius: 0;">
                                <img src="assets/images/site/locked-eye-icon.svg" alt="Locked">
                            </figure>
                        <?php else : ?>
                            <?php if (isset($prompt['example_image2'])) : ?>
                                <figure style="background-image: url(<?php echo $prompt['example_image2']; ?>)" alt="Example image 2"></figure>
                            <?php endif; ?>
                            <?php if (isset($prompt['example_image3'])) : ?>
                                <figure style="background-image: url(<?php echo $prompt['example_image3']; ?>)" alt="Example image 3"></figure>
                            <?php endif; ?>
                            <?php if (isset($prompt['example_image4'])) : ?>
                                <figure style="background-image: url(<?php echo $prompt['example_image4']; ?>)" alt="Example image 4"></figure>
                            <?php endif; ?>
                        <?php endif; ?>
                    </section>
                </div>
            </div>
        </div>
    </main>
</body>
</html>