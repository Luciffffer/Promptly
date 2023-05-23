<?php 

    require_once(__DIR__ . "/../vendor/autoload.php");

    use Promptly\Core\User;
    use Promptly\Helpers\Token;
    use Promptly\Helpers\Email;
    use Promptly\Helpers\Security;

    Security::onlyNonLoggedIn();

    try {
        if (!empty($_POST['email'])) {
            
            // get user
            $user = User::getUserByEmail($_POST['email']);
            
            // create token
            $token = new Token();
            $token->generateToken($_POST['email']);
            $token->setType("password");
            $token->setUserId($user['id']);
            $token->insertToken();

            // send email
            $email = new Email();
            $email->setToEmail($user['email']);
            $email->setToken($token->getToken());
            $email->setUsername($user['username']);
            $email->sendPasswordReset();

            $success = "A password reset email has been send! Please check your inbox and click on the link. <strong>Token is only valid for 24 hours!</strong>";

        }

        if (!empty($_GET['token'])) {
            // check if token is valid and get it
            $token = Token::getTokenObject($_GET['token'], "password");
            $tokenValid = true;

            if (!empty($_POST['new-password'])) {
                // update password
                $newUser = new User();
                $newUser->setPassword($_POST['new-password']);
                $newUser->setId($token['user_id']);
                $newUser->updateUser();

                // delete token
                Token::deleteToken($token['id']);

                $success = "Your password has been updated! Log in with the button in the top right corner.";
            }
        }
    } catch (Throwable $err) {
        $error = $err->getMessage();
    }

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/signup.css">
    <link rel="shortcut icon" href="../assets/images/site/promptly-logo.svg" type="image/x-icon">
    <title>Password Reset - Promptly</title>
</head>
<body>
    <a style="display: none;" href="#content">Jump to content.</a>
    <figure id="grey-shape-bg"></figure>
    <div>
        <header>
            <nav>
                <a href="../index" class="white-a">
                    <img src="../assets/images/site/house-icon.svg" alt="Icon of a house">
                    Home
                </a>
                <a href="../login" class="white-a">Login</a>
            </nav>
            <div id="brand-text">
                <div class="logo-container">
                    <img src="../assets/images/site/promptly-logo.svg" alt="Logo">
                    <h1 class="logo-text">Promptly</h1>
                </div>
                <p>The best platform to find prompts quickly.</p>
            </div>
        </header>

        <main id="content">
            <?php if (isset($success)) : ?>
                <div id="success-container">
                    <img src="../assets/images/site/success-icon.svg" alt="Success icon">
                    <h2>Success!</h2>
                    <p><?php echo $success; ?></p>
                </div>
            <?php elseif (isset($error)) : ?>
                <div id="error-container">
                    <img src="../assets/images/site/warning-icon.svg" alt="Warning icon">
                    <p><?php echo $error; ?></p>
                </div>
            <?php endif; ?>

            <?php if (empty($_GET['token'])) : ?>
                <form id="sign-up-form" action="" method="POST" aria-label="Reste password form">
                    <h2 class="form-title">Reset password</h2>
                    <p>So you forgot your password? Don't worry it happens to all of us at least once.</p>
                    <p>Fill out the form below and we'll send you an email to reset your password!</p>

                    <div style="margin-top: 2rem;" class="form-part">
                        <label for="email">Your email</label>
                        <input type="text" name="email" id="email" placeholder="example@gmail.com">
                    </div>

                    <input class="primary-btn button" type="submit" value="Reset password">
                </form>
            <?php endif; ?>

            <?php if (isset($tokenValid)) : ?>
                <form id="sign-up-form" action="" method="POST" aria-label="Reste password form">
                    <h2 class="form-title">Reset password</h2>
                    <p>Enter your new password below</p>

                    <div class="form-part">
                        <label for="password">Password</label>
                        <div class="password-input">
                            <input type="password" name="new-password" id="password" placeholder="...">
                            <a data-button="show-hide-password" style="background-image: url(../assets/images/site/hidden-icon.svg)" class="show-password" aria-label="Show password"></a>
                            <a data-button="show-hide-password" style="background-image: url(../assets/images/site/show-icon.svg)" class="show-password hidden" aria-label="Hide password"></a>
                        </div>
                        <small>Must be more than 8 characters</small>
                    </div>

                    <input class="primary-btn button" type="submit" value="Reset password">
                </form>
            <?php endif; ?>
        </main>
    </div>
    <footer>
        <p>&copy; 2023 Promptly. All Rights Reserved.</p>
    </footer>
    <script src="../assets/js/show-password.js"></script>
</body>
</html>