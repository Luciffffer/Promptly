<?php 

require_once(__DIR__ . '/vendor/autoload.php');

use Promptly\Core\Prompt;
use Promptly\Core\User;
use Promptly\Core\Like;
use Promptly\Core\File;
use Promptly\Core\Report;
use Promptly\Core\Comment;

session_start();

try {
    if (!empty($_GET['id'])) {

        $prompt = Prompt::getPromptById($_GET['id']);
    
        $isAuthor = (isset($_SESSION['userId']) && $prompt['author_id'] == $_SESSION['userId']) ? true : false;
    
        if ($prompt['approved'] == 0 && !$isAuthor && !isset($_SESSION['isModerator'])) {
            throw new Exception("Prompt not found.");
        }
    
        if (!empty($_POST['delete']) && $_POST['delete'] == 'true') {
            if ($isAuthor || isset($_SESSION['isModerator'])) {
                $newPrompt = new Prompt();
                $newPrompt->setId($_GET['id']);
                $newPrompt->deletePrompt();
                File::deleteFile($prompt['header_image']);
                File::deleteFile($prompt['example_image1']);
    
                if (isset($prompt['example_image2'])) {
                    File::deleteFile($prompt['example_image2']);
                }
                if (isset($prompt['example_image3'])) {
                    File::deleteFile($prompt['example_image3']);
                }
                if (isset($prompt['example_image4'])) {
                    File::deleteFile($prompt['example_image4']);
                }
    
                throw new Exception("Prompt deleted successfully.");
            }
        }
    
        $model = Prompt::getModelById($prompt['model_id']);
        $categories = Prompt::getCategoriesByPromptId($_GET['id']);
        $author = User::getUserById($prompt['author_id']);
        $tags = json_decode($prompt['tags'], true);
        $AllLikes = Like::getLikes($_GET['id']);
    
        if (!$isAuthor) {
            Prompt::addView($_GET['id']);
        }
    
    } else {
        throw new Exception("Prompt not found.");
    }
} catch (Throwable $err) {
    header("Location: discover");
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
        <div style="position: relative">

            <div id="feedback-container" class="hidden feedback-container-hidden">
                <a href="#" id="feedback-close-btn">
                    <img src="assets/images/site/cross-symbol-no-circle.svg" alt="Close">
                </a>
                <div id="feedback-content"></div>
            </div>

            <?php if ($isAuthor || isset($_SESSION['isModerator'])) : ?>
                <dialog id="delete-prompt-container">
                    <form action="" method="POST">
                        <h2>Delete Prompt</h2>
                        <hr>
                        <p><strong>Are you sure you want to delete this prompt?</strong> This action cannot be undone.</p>
                        <div id="delete-prompt-buttons">
                            <button data-close-delete class="button primary-btn-white">Cancel</button>
                            <button id="delete-btn" class="button" type="submit" name="delete" value="true">Delete</button>
                        </div>
                    </form>
                </dialog>
            <?php endif; ?>

            <?php if (isset($_SESSION['loggedIn'])) : ?>
                <?php
                    $report = new Report();
                    $allowedReasons = $report->getAllowedReasons();
                ?>
                <dialog id="report-prompt-container">
                    <h2>Report Prompt</h2>
                    <a href="#" id="close-report-btn">
                        <img src="assets/images/site/cross-symbol-no-circle.svg" alt="Close" data-close-report>
                    </a>
                    <hr>
                    <div id="report-form-content">
                        <div class="form-part">
                            <label for="report-reason">Reason:</label>
                            <select data-report-reason id="report-reason">
                                <?php foreach ($allowedReasons as $reason) : ?>
                                    <option value="<?php echo $reason; ?>" ><?php echo $reason; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-part">
                            <label for="report-extra-information">Extra information:</label>
                            <textarea id="report-extra-information" data-report-extra-information cols="30" rows="10"></textarea>
                        </div>
                        <a href="#" class="button" id="submit-report-btn">Submit Report</a>
                    </div>
                </dialog>
            <?php endif; ?>

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
                                    <?php if ($isAuthor || (isset($_SESSION['isModerator']) && $_SESSION['isModerator'] === true)) : ?>
                                        <div id="prompt-gotten-container">
                                            <img src="assets/images/site/success-icon.svg" alt="Checkmark">
                                            <span>You own this prompt!</span>
                                        </div>
                                    <?php elseif ($prompt['free']) : ?>
                                        <a class="button" id="get-prompt-btn" href="#">
                                            <img src="assets/images/site/plus-circle-icon.svg" alt="Get icon">
                                            <span>Get prompt for free!</span>    
                                        </a>
                                    <?php else : ?>
                                        <a class="button" id="get-prompt-btn" href="#">
                                            <img src="assets/images/site/plus-circle-icon.svg" alt="Get icon">
                                            <span>Get prompt</span>
                                        </a>
                                        <small>It's only 1 credit!</small>
                                    <?php endif; ?>
                                </div>
                                <div id="single-prompt-action-section-right">
                                    <a id="like-btn" href="#" aria-label="Like prompt" data-liked="<?php echo Like::isLiked($_SESSION['userId'], $_GET['id']) ? 'true' : 'false'; ?>"></a>
                                    <span id="likes-count"><?php echo $AllLikes; ?></span>
                                    <hr>
                                    <div data-dropdown class="dropdown">
                                        <button id="prompt-more-options-button" href="#" aria-label="More options" data-dropdown-btn></button>
                                        <div id="prompt-more-options">
                                            <a href="#" data-share-prompt-btn>
                                                <img src="assets/images/site/share-icon.svg" alt="Share">
                                                <span>Copy link</span>
                                            </a>
                                            <a href="#" id="report-prompt-btn" data-report-prompt-btn>
                                                <img src="assets/images/site/warning-icon.svg" alt="Warning">
                                                <span>Report prompt</span>
                                            </a>
                                            <?php if ($isAuthor || isset($_SESSION['isModerator'])) : ?>
                                                <a href="#" id="delete-prompt-btn" data-delete-prompt-btn>
                                                    <img src="assets/images/site/trash-icon-white.svg" alt="Trash">
                                                    <span>Delete prompt</span>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                        <script src="assets/js/prompt-more-options.js"></script>
                                    </div>
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
                                                    <small><?php echo \Promptly\Helpers\Date::getElapsedtime($comment['date_created']); ?></small>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    // William used jquery for this. Increases loading time. I would recommend using vanilla js instead

    var promptId = <?php echo $_GET['id']; ?>;

    // Not safe. User can change this and thus make other users like the prompt
    // UserId should not be send with ajax. It should be gotten from session in toggle-like.ajax.php
    var userId = <?php echo $_SESSION['userId']; ?>;

    var AllLikes = $('#likes-count'); // Get the likes count element

    $(document).ready(function() {
        $('#like-btn').click(function(event) {
            event.preventDefault();

            // right now the like button lags. That's because we wait for the ajax response before we change the like button
            // if you have extra time it would be great to change the like button before the ajax response
            // create a variable called isLiked and change it together with the like button style when clicked. Don't wait for response
            // if the response throws an error then change the like button back to the previous state. Otherwise don't do anything

            $.ajax({
                url: './ajax/toggle-like.ajax.php',
                type: 'POST',
                data: {
                    prompt_id: promptId,
                    user_id: userId
                },
                success: function(response) {
                    if (response === 'added') {
                        AllLikes.text(parseInt(AllLikes.text()) + 1); 
                        document.getElementById("like-btn").dataset.liked = "true";
                        console.log('Liked prompt.');
                    } else if (response === 'removed') {
                        AllLikes.text(parseInt(AllLikes.text()) - 1);
                        document.getElementById("like-btn").dataset.liked = "false";
                        console.log('Removed like from prompt.');
                    } else {
                        console.log('Failed to toggle like.');
                    }
                },
            });
        });
    });
</script>

</body>
</html>