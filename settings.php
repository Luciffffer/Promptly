<?php 

include_once(__DIR__ . "/classes/Security.php");
include_once(__DIR__ . "/classes/User.php");

Security::onlyLoggedIn();
$user = User::getUserById($_SESSION['userId']);

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings - Promptly</title>
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
                    <img src="<?php echo $user['profile_pic'] ?>" alt="Profile pic">
                    <div>
                        <p style="margin-bottom: -1rem;">Account</p>
                        <h1 id="profile-header-username"><?php echo htmlspecialchars($user['username']); ?></h1>
                        <div id="profile-header-information">
                            <span>22 Prompts</span>
                            <span>34 Followers</span>
                            <span>13 Likes</span>
                        </div>
                    </div>
                </div>
            </header>
            <div style="padding: 0 3rem">
                <div class="center">
                    <h1>Settings</h1>
                    <section class="settings-section">
                        <h2>General settings</h2>
                        <p>What other people are able to see about you.</p>
                        <a href="#" id="settings-profile-img">
                            <span>Profile image</span>
                            <span>A custom profile image adds a lot to an account!</span>
                            <figure class="profile-image" style="background-image: url(<?php echo $user['profile_pic']; ?>);"></figure>
                        </a>
                        <a href="#">
                            <span>Username</span>
                            <span><?php echo htmlspecialchars($user['username']); ?></span>
                            <figure class="right-arrow"></figure>
                        </a>
                        <a href="#">
                            <span>Biography</span>
                            <span><?php echo htmlspecialchars($user['biography']); ?></span>
                            <figure class="right-arrow"></figure>
                        </a>
                    </section>
                    <section class="settings-section">
                        <h2>Sensitive settings</h2>
                        <a href="#">
                            <span>Email</span>
                            <span><?php echo htmlspecialchars($user['email']); ?></span>
                            <figure class="right-arrow"></figure>
                        </a>
                        <a href="#">
                            <span>Password</span>
                            <span></span>
                            <figure class="right-arrow"></figure>
                        </a>
                    </section>
                    <section class="settings-section">
                        <h2>Account deletion/deactivation</h2>
                        <p>We care about you and your privacy. Even if it means letting you go. Here you can fully delete your account and all associated date or simply deactivate your account. <strong>Deactivation is hiding your profile and data from the public until you log in again. Deletion is permanent and complete.</strong></p>
                        <div id="deletion-container">
                            <a href="#" class="button">Deactivate my account</a>
                            <a href="#" class="button">Delete my account</a>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
<!-- Look at you sneaking a peak behind the scenes. Well, have fun! If you find any bugs please contact us :) -->