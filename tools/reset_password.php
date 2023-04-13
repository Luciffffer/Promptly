<?php 

    include_once(__DIR__ . "/../classes/User.php");
    include_once(__DIR__ . "/../classes/Email.php");

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

        } catch (Throwable $err) {
            $error = $err->getMessage();
        }
        // create a token
        // Add token to database
        // send token
    }

    if (!empty($_GET['code'])) {
        
        
        
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
    <title>Email Verification - Promptly</title>
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

        <!-- <?php if ($success === true) : ?>
            <main id="success-container">
                <img src="../assets/images/site/success-icon.svg" alt="Success icon">
                <h2>Welcome to the club!</h2>
                <p>Your email has been verified! You can now log in with the button in the top right corner</p>
            </main>
        <?php else : ?>
            <main id="success-container" style="background-color: rgb(201, 29, 29);">
                <img src="../assets/images/site/warning-icon.svg" alt="Success icon">
                <h2>Something went wrong!</h2>
                <p>The verification code you used is most likely wrong.</p>
            </main>
        <?php endif; ?> -->

        <main>
            <form id="sign-up-form content" action="" method="POST" aria-label="Reste password form">
                <h2 class="form-title">Reset password</h2>
                <p>So you forgot your password? Don't worry it happens to all of us at least once.</p>
                <p>Fill out the form below and we'll send you an email to reset your password!</p>

                <div style="margin-top: 2rem;" class="form-part">
                    <label for="email">Your email</label>
                    <input type="text" name="email" id="email" placeholder="example@gmail.com">
                </div>

                <input class="primary-btn button" type="submit" value="Reset password">
            </form>
        </main>
    </div>
    <footer>
        <p>&copy; 2023 Promptly. All Rights Reserved.</p>
    </footer>
</body>
</html>