<?php 

require_once(__DIR__ . "/vendor/autoload.php");

use Promptly\Core\Prompt;
use Promptly\Core\User;
use Promptly\Core\Like;
use Promptly\Core\Follow;
use Promptly\Helpers\File;
use Promptly\Helpers\Security;

Security::onlyLoggedIn();

$user = User::getUserById($_SESSION['userId']);
$prompt = new Prompt();
$prompt->setAuthorId($user['id']);
$prompts = $prompt->getPrompts(approved: 1);

if (!empty($_POST) || !empty($_FILES)) {
    try {
        $newUser = new User();
        $newUser->setId($_SESSION['userId']);

        if (!empty($_POST['username'])) {
            $newUser->setUsername($_POST['username']);
        }

        if (!empty($_POST['old-password']) && !empty($_POST['new-password'])) {
            
            if (User::verifyPassword($_POST['old-password'], $user['email'])) {
                $newUser->setPassword($_POST['new-password']);
            } else {
                throw new Exception("Current password is wrong.");
            }
            
        }

        if (!empty($_FILES['profilePic'])) { // messy code should probably be in a class.
            $name = $_FILES['profilePic']['name'];
            $size = $_FILES['profilePic']['size'];
            $tmpName = $_FILES['profilePic']['tmp_name'];

            $image = new File();
            $image->setImageName($name);
            $image->validateImageSize($size);

            $path = $image->getPath();
            $newUser->setProfileImg($path);
            $image->moveImage($tmpName);
            File::deleteFile($user['profile_pic']);
        }

        if(isset($_POST['biography'])) { // check if the input button was pressed
            $biography = $_POST['biography'];
            $newUser->setBiography($biography);
        }

        if(!empty($_POST['delete-account']) && isset($_POST['password'])) { // delete user
            if (!isset($_POST['del-agree'])) {
                throw new Exception("You must agree to having your account deleted.");
            }

            if (User::verifyPassword($_POST['password'], $user['email'])) {

                $newUser->deleteUser();
                header("location: logout");

            } else {
                throw new Exception("Password is wrong.");
            }
        }

        if (!empty($_POST['deactivate-account']) && isset($_POST['password'])) {
            if (User::verifyPassword($_POST['password'], $user['email'])) {

                $newUser->deactivateUser();
                header("location: logout");

            } else {
                throw new Exception("Password is wrong.");
            }
        }

        $newUser->updateUser();
        $user = User::getUserById($_SESSION['userId']);
        $_SESSION['username'] = $user['username'];
        $_SESSION['profile-pic'] = $user['profile_pic'];
        $success = true;
    
    } catch (Throwable $err) {
        $error = $err->getMessage();
    }
}

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
    <script src="./assets/js/ajax-username-available.js" defer></script>
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
                            <span><?php echo Follow::getFollowerCount($user['id']); ?> Followers</span>
                            <span><?php echo Like::getLikesByUserId($user['id']); ?> Likes</span>
                        </div>
                    </div>
                </div>
            </header>
            <div style="padding: 0 3rem">
                <div class="center" data-div="settingsDiv">
                    <h1>Settings</h1>

                    <?php if (isset($success) && $success === true) : ?>
                        <section class="settings-section" id="settings-success-section">
                            <h2>Your profile has been updated!</h2>
                        </section>
                    <?php endif; ?>

                    <?php if (isset($error)) : ?>
                        <section class="settings-section" id="settings-error-section">
                            <img src="./assets/images/site/warning-icon.svg" alt="Warning icon">
                            <h2><?php echo $error; ?></h2>
                            <img src="./assets/images/site/warning-icon.svg" alt="Warning icon">
                        </section>
                    <?php endif; ?>

                    <section class="settings-section">
                        <h2>General settings</h2>
                        <p>What other people are able to see about you.</p>
                        <a href="#" id="settings-profile-img" data-button="profileImage">
                            <span>Profile image</span>
                            <span>A custom profile image adds a lot to an account!</span>
                            <div class="profile-image">
                                <figure style="background-image: url(<?php echo $user['profile_pic']; ?>);"></figure>
                            </div>
                        </a>
                        <a href="#" data-button="username">
                            <span>Username</span>
                            <span><?php echo htmlspecialchars($user['username']); ?></span>
                            <figure class="right-arrow"></figure>
                        </a>
                        <a href="#" data-button="biography">
                            <span>Biography</span>
                            <span>
                                <?php if(!empty($user['biography'])) {echo nl2br(htmlspecialchars($user['biography'])); } else {
                                echo "No biography yet!";} ?>
                            </span>
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
                        <a href="#" data-button="password">
                            <span>Password</span>
                            <span></span>
                            <figure class="right-arrow"></figure>
                        </a>
                    </section>
                    <section class="settings-section">
                        <h2>Account deletion/deactivation</h2>
                        <p>We care about you and your privacy. Even if it means letting you go. Here you can fully delete your account and all associated date or simply deactivate your account. <strong>Deactivation is hiding your profile and data from the public until you log in again. Deletion is permanent and complete.</strong></p>
                        <div id="deletion-container">
                            <a href="#" class="button" data-button="deactivation">Deactivate my account</a>
                            <a href="#" class="button" data-button="deletion">Delete my account</a>
                        </form>
                        </div>
                    </section>
                </div>
            </div>

            <form action="" method="POST" data-div="form">

                <div data-form="username" class="absolute-form-div hidden">
                    <div class="absolute-form">
                        <div class="title-container">
                            <img src="./assets/images/site/arrow-left.svg" alt="Back button" data-button="backButton">
                            <h2>Change Username</h2>
                        </div>
                        <p>A username is a big part of your Promptly identity. Find something cool that represents you!</p>
                        <hr>
                        <div class="form-part">
                            <label for="username">Username</label>
                            <div style="position: relative;">
                                <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($user['username']); ?>">
                                <i data-username="warning" class="valid-icon hidden" style="background-image: url(./assets/images/site/cross-symbol.svg);"></i>
                                <i data-username="success" class="valid-icon hidden" style="background-image: url(./assets/images/site/success-icon-green.svg);"></i>
                            </div>
                            <small id="username-warning">Only numbers and letters allowed.</small>
                        </div>
                        <div class="form-submit">
                            <input type="submit" value="Submit" class="primary-btn button">
                        </div>
                    </div>
                </div>
            
            </form>

            <form action="" method="POST" data-div="form">

                <div data-form="biography" class="absolute-form-div hidden">
                    <div class="absolute-form">
                        <div class="title-container">
                            <img src="./assets/images/site/arrow-left.svg" alt="Back button" data-button="backButton">
                            <h2>Change Biography</h2>
                        </div>
                        <p>Tell people in short about yourself! <strong>Max 150 characters.</strong></p>
                        <hr>
                        <div class="form-part">
                            <label for="biography">Biography</label>
                            <textarea name="biography" id="biography" cols="30" rows="7"><?php echo htmlspecialchars($user['biography']); ?></textarea>
                        </div>
                        <div class="form-submit">
                            <input type="submit" value="Submit" class="primary-btn button">
                        </div>
                    </div>
                </div>

            </form>

            <form action="" method="POST" data-div="form">

                <div data-form="password" class="absolute-form-div hidden">
                    <div class="absolute-form">
                        <div class="title-container">
                            <img src="./assets/images/site/arrow-left.svg" alt="Back button" data-button="backButton">
                            <h2>Change Password</h2>
                        </div>
                        <p>Changing your password requires you to enter your current password first.</p>
                        <hr>
                        <div class="form-part">
                            <label for="old-password">Current password</label>
                            <div class="password-input">
                                <input type="password" name="old-password" id="old-password" placeholder="...">
                                <a data-button="show-hide-password" style="background-image: url(./assets/images/site/hidden-icon.svg)" class="show-password" aria-label="Show password"></a>
                                <a data-button="show-hide-password" style="background-image: url(./assets/images/site/show-icon.svg)" class="show-password hidden" aria-label="Hide password"></a>
                            </div>
                        </div>
                        <div class="form-part">
                            <label for="new-password">New password</label>
                            <div class="password-input">
                                <input type="password" name="new-password" id="new-password" placeholder="...">
                                <a data-button="show-hide-password" style="background-image: url(./assets/images/site/hidden-icon.svg)" class="show-password" aria-label="Show password"></a>
                                <a data-button="show-hide-password" style="background-image: url(./assets/images/site/show-icon.svg)" class="show-password hidden" aria-label="Hide password"></a>
                            </div>
                            <small>Has to be more than 8 characters</small>
                        </div>
                        <div class="form-submit">
                            <input type="submit" value="Submit" class="primary-btn button">
                        </div>
                    </div>
                </div>

            </form>

            <form id="image-form" action="" method="POST" data-div="form" enctype="multipart/form-data">

                <div data-form="profileImage" class="absolute-form-div hidden">
                    <div class="absolute-form" id="profilePic-form">
                        <div class="title-container" style="margin: 0 1rem; margin-top: 1rem">
                            <img src="./assets/images/site/arrow-left.svg" alt="Back button" data-button="backButton">
                            <h2>Profile Picture</h2>
                        </div>
                        <p style="margin: 0 1rem; margin-bottom: 1rem">This is your profile picture. Click on the button to change it. <strong>Max size of 2MB</strong></p>
                        <hr>
                        <div id="profilePic-image-div">
                            <div id="profilePic-image">
                                <label for="profilePic">
                                    <figure style="background-image: url(<?php echo $user['profile_pic']; ?>);"></figure>
                                    <i></i>
                                </label>
                                <input class="hidden" type="file" name="profilePic" id="profilePic" accept=".jpg, .jpeg, .png, .webp">
                            </div>
                        </div>
                        <script type="application/javascript">
                            document.querySelector("#profilePic").onchange = () => {
                                document.querySelector("#image-form").submit();
                            }
                        </script>
                    </div>
                </div>

            </form>

            <form action="" method="POST" data-div="form">

                <div data-form="deletion" class="absolute-form-div hidden">
                    <div class="absolute-form deletion-form">
                        <div class="title-container">
                            <img src="./assets/images/site/arrow-left.svg" alt="Back button" data-button="backButton">
                            <h2>Delete Account</h2>
                        </div>
                        <p>We're sad to see you go, but don't worry we still care about you. Fill in your password below and we will delete your entire account and all related data.</p>
                        <p><strong>All associated data also includes all your likes, comments, prompts ...</strong></p>
                        <hr>
                        <div class="form-part">
                            <label for="del-password">Password</label>
                            <div class="password-input">
                                <input type="password" name="password" id="del-password" placeholder="...">
                                <a data-button="show-hide-password" style="background-image: url(./assets/images/site/hidden-icon.svg)" class="show-password" aria-label="Show password"></a>
                                <a data-button="show-hide-password" style="background-image: url(./assets/images/site/show-icon.svg)" class="show-password hidden" aria-label="Hide password"></a>
                            </div>
                        </div>
                        <div class="form-part">
                            <input type="checkbox" name="del-agree" id="del-agree">
                            <label for="del-agree">I agree to have my account and all associated data deleted</label>
                        </div>
                        <div class="form-submit">
                            <input type="submit" value="Submit" name="delete-account" class="primary-btn button">
                        </div>
                    </div>
                </div>
            
            </form>

            <form action="" method="POST" data-div="form">

                <div data-form="deactivation" class="absolute-form-div hidden">
                    <div class="absolute-form deletion-form">
                        <div class="title-container">
                            <img src="./assets/images/site/arrow-left.svg" alt="Back button" data-button="backButton">
                            <h2>Deactivate Account</h2>
                        </div>
                        <p>Deactivation means hiding your account and all associated data from the public until you log in again. We will thus hold onto your data but will not display it anywhere publically. If you log in again after deactivation your account will be activated again.</p>
                        <p><strong>All associated data also includes all your likes, comments, prompts ...</strong></p>
                        <hr>
                        <div class="form-part">
                            <label for="deact-password">Password</label>
                            <div class="password-input">
                                <input type="password" name="password" id="deact-password" placeholder="...">
                                <a data-button="show-hide-password" style="background-image: url(./assets/images/site/hidden-icon.svg)" class="show-password" aria-label="Show password"></a>
                                <a data-button="show-hide-password" style="background-image: url(./assets/images/site/show-icon.svg)" class="show-password hidden" aria-label="Hide password"></a>
                            </div>
                        </div>
                        <div class="form-submit">
                            <input type="submit" value="Submit" name="deactivate-account" class="primary-btn button">
                        </div>
                    </div>
                </div>
            
            </form>
        </div>
    </main>
    <script src="./assets/js/settings-page.js" defer></script>
    <script src="./assets/js/show-password.js" defer></script>
</body>
</html>
<!-- Look at you sneaking a peak behind the scenes. Well, have fun! If you find any bugs please contact us :) -->