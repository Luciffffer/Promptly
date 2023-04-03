<?php

    include_once(__DIR__ . "/classes/User.php");

    function canLogin($p_password, $p_email){
        $conn = Database::getInstance();
        $statement = $conn->prepare("SELECT * FROM `users` WHERE email = :email");
        $statement->bindValue(":email", $p_email);
        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if($user){
            $hash = $user['password'];
            if(password_verify($p_password, $hash)){
                return true;
            } else {
                return false;
            }
        }
    }

    if(!empty($_POST)){
        $email = $_POST['email'];
        $password = $_POST['password']; 
        if(canLogin($password, $email)){
            header("location: index.php");
        } else {
            $error = "You used the wrong email and/or password.";
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
    <a style="display: none;" href="#sign-up-form">Jump to the sign up form.</a>
    <figure id="grey-shape-bg"></figure>
    <div>
        <header>
            <nav>
                <a href="#" class="white-a">
                    <img src="assets/images/site/house-icon.svg" alt="Icon of a house">
                    Home
                </a>
                <a href="#" class="white-a">Login</a>
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

            <form id="sign-up-form" action="" method="POST" aria-label="Sign up form">
                <h2 class="form-title">Login</h2>

                <div class="form-part">
                    <label for="email">Your email</label>
                    <input type="text" name="email" id="email" placeholder="example@gmail.com">
                </div>

                <div class="form-part">
                    <label for="password">Password</label>
                    <div id="password-input">
                        <input type="password" name="password" id="password" placeholder="...">
                        <button style="background-image: url(./assets/images/site/hidden-icon.svg)" id="show-password" aria-label="Show/hide password"></button>
                    </div>
                    <!-- <small>Must be more than 8 characters</small> -->
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