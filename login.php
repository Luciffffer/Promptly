<?php

    include_once(__DIR__ . "/classes/User.php");
    include_once(__DIR__ . "/classes/Security.php");

    Security::onlyNonLoggedIn();

    if (isset($_POST['email']) && isset($_POST['password'])) {
        try {
            if (User::canLogin($_POST['password'], $_POST['email'])) {

                $user = User::getUserByEmail($_POST['email']);

                $_SESSION['username'] = $user['username'];
                $_SESSION['userId'] = $user['id'];
                $_SESSION['profile-pic'] = $user['profile_pic'];
                $_SESSION['loggedIn'] = true;

                header('location: index');

            }
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
    <title>Login - Promptly</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/signup.css">
    <link rel="shortcut icon" href="assets/images/site/promptly-logo.svg" type="image/x-icon">
</head>
<body>
    <a style="display: none;" href="#sign-up-form">Jump to the login form.</a>
    <figure id="grey-shape-bg"></figure>
    <div>
        <header>
            <nav>
                <a href="index" class="white-a">
                    <img src="assets/images/site/house-icon.svg" alt="Icon of a house">
                    Home
                </a>
                <a href="register" class="white-a">Sign up</a>
            </nav>
            <div id="brand-text">
                <div class="logo-container">
                    <img src="./assets/images/site/promptly-logo.svg" alt="Logo">
                    <h1 class="logo-text">Promptly</h1>
                </div>
                <p>The best platform to find prompts quickly.</p>
            </div>
        </header>
        <main>
            <?php if (isset($error)) : ?>
                <div id="error-container">
                    <img src="./assets/images/site/warning-icon.svg" alt="Warning icon">
                    <p><?php echo $error; ?></p>
                </div>
            <?php endif; ?>

            <form id="sign-up-form" action="" method="POST" aria-label="Login form">
                <h2 class="form-title">Login</h2>

                <div class="form-part">
                    <label for="email">Your email</label>
                    <input type="text" name="email" id="email" placeholder="example@gmail.com">
                </div>

                <div class="form-part">
                    <label for="password">Password</label>
                    <div class="password-input">
                        <input type="password" name="password" id="password" placeholder="...">
                        <a data-button="show-hide-password" style="background-image: url(./assets/images/site/hidden-icon.svg)" class="show-password" aria-label="Show password"></a>
                        <a data-button="show-hide-password" style="background-image: url(./assets/images/site/show-icon.svg)" class="show-password hidden" aria-label="Hide password"></a>
                    </div>
                    <a class="grey-a" href="./tools/reset-password"><small>I forgot my password</small></a>
                </div>

                <input class="primary-btn button" type="submit" value="Login">
            </form>
            <section aria-label="Section with buttons to sign in with Google, Github, or Facebook.">
                <span class="line-both-sides">or</span>
                <p style="margin-bottom: 1rem">Sign in with:</p>
                <div id="sign-in-with-container">
                    <a href="#" aria-label="Sign in with Google" class="sign-in-with-block button">
                        <img src="assets/images/site/google-logo.png" alt="Google logo">
                    </a>
                    <a href="#" aria-label="Sign in with Github" class="sign-in-with-block button">
                        <img src="assets/images/site/github-logo.png" alt="Github logo">
                    </a>
                    <a href="#" aria-label="Sign in with Facebook" class="sign-in-with-block button">
                        <img src="assets/images/site/facebook-logo.png" alt="Facebook logo">
                    </a>
                </div>
            </section>
        </main>
    </div>
    <footer>
        <p>&copy; 2023 Promptly. All Rights Reserved.</p>
    </footer>
    <script src="./assets/js/show-password.js"></script>
</body>
</html>