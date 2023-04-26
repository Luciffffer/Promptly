<?php 

include_once(__DIR__ . "/classes/Security.php");
include_once(__DIR__ . "/classes/User.php");

Security::onlyLoggedIn();
$user = User::getUserById($_SESSION['userId']);

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

        if (!empty($_FILES['profilePic'])) {
            $name = $_FILES['profilePic']['name'];
            $size = $_FILES['profilePic']['size'];
            $tmpName = $_FILES['profilePic']['tmp_name'];

            // validate image
            $validExtensions = ['jpg', 'jpeg', 'png', 'webp'];
            $extension = explode('.', $name);
            $extension = strtolower(end($extension));

            if (!in_array($extension, $validExtensions)) {
                throw new Exception("Invalid image extention.");
            }

            if ($size > 2000000) {
                throw new Exception("Image size is too large.");
            }

            $newName = md5($name) . '-' . date('Y.m.d.H.i.s') . '.' . $extension;
            $newUser->setProfileImg($newName);
            move_uploaded_file($tmpName, __DIR__ . '/assets/images/user-submit/' . $newName);
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
                            <span>22 Prompts</span>
                            <span>34 Followers</span>
                            <span>13 Likes</span>
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
                            <a href="#" class="button">Deactivate my account</a>
                            <a href="#" class="button">Delete my account</a>
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
                            <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($user['username']); ?>">
                            <small>Only numbers and letters allowed.</small>
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
        </div>
    </main>
    <script src="./assets/js/settings-page.js" defer></script>
    <script src="./assets/js/show-password.js" defer></script>
</body>
</html>
<!-- Look at you sneaking a peak behind the scenes. Well, have fun! If you find any bugs please contact us :) -->