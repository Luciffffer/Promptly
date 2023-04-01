<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up to Promptly</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="shortcut icon" href="assets/images/site/promptly-logo.svg" type="image/x-icon">
</head>
<body>
    <header>
        <nav>
            <a href="#">
                <!-- icon -->
                <p>Home</p>
            </a>
            <a href="#">Login</a>
        </nav>
        <div>
            <img src="./assets/images/site/promptly-logo.svg" alt="Logo">
            <h1>Promptly</h1>
        </div>
        <p>The best platform to find prompts quickly.</p>
    </header>
    <main>
        <form action="" method="POST">
            <h2>Sign up</h2>

            <div>
                <label for="username">Username</label>
                <input type="text" name="username" id="username" placeholder="PromptKing20">
            </div>

            <div>
                <label for="email">Your email</label>
                <input type="text" name="email" id="email" placeholder="example@gmail.com">
            </div>

            <div>
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
            </div>

            <div>
                <input type="checkbox" name="terms-agree" id="terms-agree"> 
                <label for="terms-agree">
                    I have read and accept the 
                    <a href="#">terms and conditions</a>
                </label>   
            </div>

            <input type="submit" value="Sign me up!">
        </form>
        <section aria-label="Section with buttons to sign in with Google, Github, or Facebook.">
            <span>or</span>
            <p>Sign in with:</p>
            <div>
                <a href="#" aria-label="Sign in with Google">
                    <img src="assets/images/site/google-logo.png" alt="Google logo">
                </a>
                <a href="#" aria-label="Sign in with Github">
                    <img src="assets/images/site/github-logo.png" alt="Github logo">
                </a>
                <a href="#" aria-label="Sign in with Facebook">
                    <img src="assets/images/site/facebook-logo.png" alt="Facebook logo">
                </a>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2023 Promptly. All Rights Reserved.</p>
    </footer>
</body>
</html>