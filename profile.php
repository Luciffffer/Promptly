<?php 

include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/Report.php");

session_start();

try {
    if (!empty($_GET['id'])) {
        $user = User::getUserById($_GET['id']);
    } else {
        header("location: index");
    }
} catch (Throwable $err) {
    header("location: index");
}

if(isset($_POST['report-reason']) && isset($_POST['report-description'])){
    $report = new Report();
    $report->setUser_id($_GET['id']);
    $report->setReason($_POST['report-reason']);
    $report->setDescription($_POST['report-description']);
    $report->setReport_id($_SESSION['userId']);
    $report->saveReport();
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
                <div id="profile-header-div" class="center">
                    <figure style="background-image: url(<?php echo $user['profile_pic'] ?>);"></figure>
                    <div>
                        <p style="margin-bottom: -1rem;">Account</p>
                        <h1 id="profile-header-username"><?php echo htmlspecialchars($user['username']); ?></h1>
                        <img id="flag-icon" src="assets/images/site/flag.svg" alt="" onclick="showReport()">
                        <div id="profile-header-information">
                            <span>22 Prompts</span>
                            <span>34 Followers</span>
                            <span>13 Likes</span>
                        </div>
                    </div>
                </div>
            </header>
            <div class="center">
                <section id="profile-information" aria-label="Information about the user">
                    <?php if (!empty($user['biography'])) : ?>
                        <div>
                            <h3>Biography</h3>
                            <p><?php echo nl2br(htmlspecialchars($user['biography'])); ?></p>
                        </div>
                    <?php endif; ?>

                    <div class="achievements-container">
                        <h3>Achievements</h3>
                    </div>
                </section>
                <section>
                    <h2><?php echo htmlspecialchars($user['username']); ?>'s Prompts</h2>
                </section>
            </div>
        </div>

        <div id="report-screen" style="display:none">
            <h1>Report this user</h1>
            <p id="close" onclick="closeReport()">X</p>
            <form action="" method="POST">
                <label for="report-reason">Reason</label>
                <select name="report-reason" id="report-reason">
                    <option value="1">Spam</option>
                    <option value="2">Inappropriate</option>
                    <option value="3">Other</option>
                </select>

                <label for="report-description"><br><br>Description</label>
                <textarea name="report-description" id="report-description" cols="30" rows="10"></textarea>

                <input id="rpt-btn" type="submit" value="Report">
            </form>
        </div>
    </main>
</body>
<script>

var reportScrn = document.getElementById("report-screen");
var closeBtn = document.getElementById("close");
    function showReport() {
        reportScrn.style.display = "block"; 
    }

    function closeReport(){
        reportScrn.style.display = "none";
    }
</script>
</html>
