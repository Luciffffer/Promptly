<?php

    include_once(__DIR__ . "/classes/User.php");

    if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['username'])) {
        try {
            if (empty($_POST['terms-agree'])) {
                throw new Exception("To create an account you must accept the terms and conditions.");
            }

            $user = new User();
            $user->setUsername($_POST['username'])->setEmail($_POST['email'])->setPassword($_POST['password']);
            $success = $user->insertUser();

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
    <title>Sign up - Promptly</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/signup.css">
    <link rel="shortcut icon" href="assets/images/site/promptly-logo.svg" type="image/x-icon">
</head>
<body>
    <a style="display: none;" href="#sign-up-form">Jump to the sign up form.</a>
    <figure id="grey-shape-bg"></figure>
    <div>
        <header>
            <nav>
                <a href="index" class="white-a">
                    <img src="assets/images/site/house-icon.svg" alt="Icon of a house">
                    Home
                </a>
                <a href="login" class="white-a">Login</a>
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

            <?php if (isset($success) && $success === true) : ?>
                <div id="success-container">
                    <img src="./assets/images/site/success-icon.svg" alt="Success icon">
                    <p>A verification email has been send to your email address. You can only log in after your email is verified!</p>
                </div>
            <?php endif; ?>

            <form id="sign-up-form" action="" method="POST" aria-label="Sign up form">
                <h2 class="form-title">Sign up</h2>

                <div class="form-part">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" placeholder="PromptKing20">
                </div>

                <div class="form-part">
                    <label for="email">Your email</label>
                    <input type="text" name="email" id="email" placeholder="example@gmail.com">
                </div>

                <div class="form-part">
                    <label for="password">Password</label>
                    <div id="password-input">
                        <input type="password" name="password" id="password" placeholder="...">
                        <a style="background-image: url(./assets/images/site/hidden-icon.svg)" id="show-password" aria-label="Show/hide password"></a>
                    </div>
                    <small>Must be more than 8 characters</small>
                </div>

                <div class="form-part">
                    <input type="checkbox" name="terms-agree" id="terms-agree"> 
                    <label for="terms-agree">
                        I have read and accept the 
                        <a href="#">terms and conditions</a>
                    </label>   
                </div>

                <input class="primary-btn button" type="submit" value="Sign me up!">
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