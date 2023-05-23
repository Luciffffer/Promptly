<?php 

    require_once(__DIR__ . "/../vendor/autoload.php");

    use Promptly\Core\User;
    use Promptly\Core\Achievement;
    use Promptly\Helpers\Security;
    use Promptly\Helpers\Token;

    Security::onlyNonLoggedIn();

    if (!empty($_GET['code'])) {
        try {
            $token = Token::getTokenObject($_GET['code'], "email");
            User::verifyEmail($token['user_id']);
            Token::deleteToken($token['id']);
            Achievement::unlockAchievement(1, $token['user_id']);
            $success = true;
        } catch (Throwable $err) {
            $error = $err->getMessage();
        }
    } else {
        header('location: ../index');
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
    <a style="display: none;" href="#success-container">Jump to content.</a>
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

        <?php if (isset($success) && $success) : ?>
            <main id="success-container">
                <img src="../assets/images/site/success-icon.svg" alt="Success icon">
                <h2>Welcome to the club!</h2>
                <p>Your email has been verified! You can now log in with the button in the top right corner</p>
            </main>
        <?php else : ?>
            <main id="success-container" style="background-color: rgb(201, 29, 29);">
                <img src="../assets/images/site/warning-icon.svg" alt="Success icon">
                <h2>Something went wrong!</h2>
                <p><?php echo $error; ?></p>
            </main>
        <?php endif; ?>
    </div>
    <footer>
        <p>&copy; 2023 Promptly. All Rights Reserved.</p>
    </footer>
</body>
</html>