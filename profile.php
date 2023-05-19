<?php 

include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/Prompt.php");
include_once(__DIR__ . "/classes/Achievement.php");

session_start();

try {
    if (!empty($_GET['id'])) {
        if (!empty($_GET['order'])) {
            $order = $_GET['order'];
        } else {
            $order = '';
        }

        $user = User::getUserById($_GET['id']);
        $achievements = Achievement::getAchievementsByUserId($_GET['id']);

        $prompt = new Prompt();
        $prompt->setAuthorId($_GET['id']);
        $prompts = $prompt->getPrompts(order: $order, approved: 1);
    } else {
        throw new Exception("No user id set in the url");
    }
} catch (Throwable $err) {
    header("location: index");
    exit();
}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($user['username']); ?>'s Profile - Promptly</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="shortcut icon" href="assets/images/site/promptly-logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/platform.css">
</head>
<body>
    <?php include_once(__DIR__ . "/partials/nav.inc.php"); ?>
    <main>
        <?php include_once(__DIR__ . "/partials/aside.inc.php"); ?>
        <div>
            <header id="profile-header">
                <div id="profile-header-div" class="center">
                    <figure style="background-image: url(<?php echo $user['profile_pic'] ?>);"></figure>
                    <div>
                        <p style="margin-bottom: -1rem;">Account</p>
                        <h1 id="profile-header-username"><?php echo htmlspecialchars($user['username']); ?></h1>
                        <div id="profile-header-information">
                            <span><?php echo count($prompts); ?> Prompts</span>
                            <span>34 Followers</span>
                            <span>13 Likes</span>
                        </div>
                    </div>
                </div>
            </header>
            <div class="center-parent">
                <div class="center" id="profile-grid">
                    <section id="profile-prompts">
                        <div id="profile-prompts-list">
                            <?php foreach ($prompts as $prompt) : ?>

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
                    </section>
                    <div>
                        <section id="profile-action-section">
                            <a href="#" class="button">Follow</a>
                        </section>
                        <section id="profile-about-section">
                            <h2>About</h2>
                            <hr class="grey-hr">
                            <div>
                                <h3>Biography</h3>
                                <p id="biography-container">
                                    <?php 
                                        if (!empty($user['biography'])) {
                                            echo nl2br(htmlspecialchars($user['biography']));
                                        } else {
                                            echo '<span class="grey">No biography yet...</span>';
                                        }
                                    ?>
                                </p>
                            </div>
                            <div>
                                <h3>Achievements</h3>
                                <div id="profile-achievements">
                                    <?php foreach ($achievements as $achievement) : ?>
                                        <div class="achievement">
                                            <img src="<?php echo $achievement['cover'] ?>" alt="<?php echo $achievement['title'] ?>">
                                            <span><?php echo $achievement['title'] ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>