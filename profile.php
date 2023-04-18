<?php 

include_once(__DIR__ . "/classes/User.php");

session_start();

if (!empty($_GET['id'])) {
    $user = User::getUserById($_GET['id']);
}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($user['username']); ?>'s Profile - Promptly</title>
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
                <img src="<?php echo $user['profile_pic'] ?>" alt="Profile pic">
                <div>
                    <p style="margin-bottom: -1rem;">Account</p>
                    <h1 id="profile-header-username"><?php echo htmlspecialchars($user['username']); ?></h1>
                    <div id="profile-header-information">
                        <span>22 Prompts</span>
                        <span>34 Followers</span>
                        <span>13 Likes</span>
                    </div>
                </div>
            </header>
        </div>
    </main>
</body>
</html>