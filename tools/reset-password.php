<?php 

    include_once(__DIR__ . "/../classes/User.php");
    include_once(__DIR__ . "/../classes/Email.php");
    include_once(__DIR__ . "/../classes/Security.php");

    Security::onlyNonLoggedIn();

    if (!empty($_POST['email'])) {
        try {
            $user = User::getUserByEmail($_POST['email']);
            $token = Security::generateToken($_POST['email']);

            $PDO = Database::getInstance();
            $stmt = $PDO->prepare("insert into temp_tokens (user_id, token) values (:user_id, :token)");
            $stmt->bindValue(":user_id", $user['id']);
            $stmt->bindValue(":token", $token);
            $stmt->execute();

            if ($stmt->rowCount() == 0) throw new Exception("Something went wrong. Try again later");

            $email = new Email();
            $email->sendPasswordReset($user['email'], $token, $user['username']);

            $success = "A password reset email has been send! Please check your inbox and click on the link.";

        } catch (Throwable $err) {
            $error = $err->getMessage();
        }
    }

    if (!empty($_GET['token'])) {
        try {
            // check if token is valid
            $tokenValid = Security::verifyToken();

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

            <?php if (empty($_GET['token']) || isset($error)) : ?>
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
                        <div id="password-input">
                            <input type="password" name="password" id="password" placeholder="...">
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
</body>
</html>