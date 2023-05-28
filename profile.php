<?php 

require_once(__DIR__ . "/vendor/autoload.php");

use Promptly\Core\Prompt;
use Promptly\Core\User;
use Promptly\Core\Achievement;
use Promptly\Core\Follow;
use Promptly\Core\Like;
use Promptly\Core\Report;

session_start();

try {
    if (!empty($_GET['id'])) {
        if (!empty($_GET['order'])) {
            $order = $_GET['order'];
        } else {
            $order = '';
        }

        $user = User::getUserById($_GET['id']);
        $achievements = Achievement::getAchievementsByUserId($_GET['id']);

        $prompt = new Prompt();
        $prompt->setAuthorId($_GET['id']);
        $prompts = $prompt->getPrompts(order: $order, approved: 1, limit: 100); // should use infinite scroll, but not enough time
    } else {
        throw new Exception("No user id set in the url");
    }
} catch (Throwable $err) {
    header("location: index");
    exit();
}

if(isset($_POST['report-reason']) && isset($_POST['report-description'])){ // zegher, please check if user is logged in. Non logged in users cannot report
    $report = new Report();
    $report->setUserId($_GET['id']);
    $report->setReason($_POST['report-reason']);
    $report->setExtraInformation($_POST['report-description']);
    $report->setReporterId($_SESSION['userId']);
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
    <script src="assets/js/profile-follow-ajax.js" defer></script>
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
                        <div id="profile-header-information">
                            <?php if ($user['verified'] == 1) : ?>
                                <span class="verified-span">
                                    <img src="assets/images/site/white-checkmark.svg" alt="Verified">
                                    <span>Verified</span>
                                </span>
                            <?php endif; ?>
                            <span><?php echo count($prompts); ?> Prompts</span>
                            <span data-follower-count><?php echo Follow::getFollowerCount($_GET['id']); ?> Followers</span>
                            <span><?php echo Like::getLikesByUserId($_GET['id']); ?> Likes</span>
                        </div>
                    </div>
                </div>
            </header>
            <div class="center-parent">
                <div class="center" id="profile-grid">
                    <section id="profile-prompts">
                        <div id="profile-prompts-list">
                            <?php foreach ($prompts as $prompt) : ?>

                                <?php 
                                    $promptTags = json_decode($prompt['tags'], true);  
                                    $promptModel = Prompt::GetModelById($prompt['model_id']);
                                ?>
                                <div>
                                    <a href="prompt?id=<?php echo $prompt['id']; ?>" class="prompt-card-header" style="background-image: url(<?php echo $prompt['header_image']; ?>)">
                                        <div class="prompt-card-header-model">
                                            <img src="<?php echo $promptModel['icon']; ?>" alt="<?php echo $promptModel['name']; ?>">
                                            <span><?php echo $promptModel['name']; ?></span>
                                        </div>
                                    </a>
                                    <div class="prompt-card-body">
                                        <div class="prompt-card-body-left">
                                            <a class="white-a" href="prompt?id=<?php echo $prompt['id']; ?>"><?php echo htmlspecialchars($prompt['title']); ?></a>
                                            <small class="prompt-card-tags">
                                                <?php for ($i = 0; $i < 4 && isset($promptTags[$i]); ++$i) : ?>
                                                    <span><?php echo htmlspecialchars($promptTags[$i]); ?></span>
                                                <?php endfor; ?>
                                            </small>
                                        </div>
                                        <a href="prompt?id=<?php echo $prompt['id']; ?>" class="button prompt-card-arrow">
                                            <img src="assets/images/site/arrow-right.svg" alt="Arrow">
                                        </a>
                                    </div>
                                </div>

                            <?php endforeach; ?>
                        </div>
                    </section>
                    <div>
                        <?php if (!isset($_SESSION['userId']) || $_SESSION['userId'] != $_GET['id']) : ?>
                            <section id="profile-action-section">
                                <?php if (!isset($_SESSION['loggedIn'])) : ?>
                                    <a href="login.php" class="button">Follow</a>
                                    <a href="login.php" id="profile-report-btn" class="button">
                                        <img id="flag-icon" src="assets/images/site/flag.svg" alt="">
                                        <span>Report</span>
                                    </a>
                                <?php else : ?>
                                    <?php if (!Follow::isFollowing($_SESSION['userId'], $_GET['id'])) : ?>
                                        <a href="#" data-follow="false" class="button">Follow</a>
                                    <?php else : ?>
                                        <a href="#" data-follow="true" class="button">Unfollow</a>
                                    <?php endif; ?>
                                    <a href="#" class="button" id="profile-report-btn" onclick="showReport()">
                                        <img id="flag-icon" src="assets/images/site/flag.svg" alt="flag">
                                        <span>Report</span>
                                    </a>
                                <?php endif; ?>
                            </section>
                        <?php endif; ?>
                        <section id="profile-about-section">
                            <h2>About</h2>
                            <hr class="grey-hr">
                            <div>
                                <h3>Biography</h3>
                                <p id="biography-container">
                                    <?php 
                                        if (!empty($user['biography'])) {
                                            echo nl2br(htmlspecialchars($user['biography']));
                                        } else {
                                            echo '<span class="grey">No biography yet...</span>';
                                        }
                                    ?>
                                </p>
                            </div>
                            <div>
                                <h3>Achievements</h3>
                                <div id="profile-achievements">
                                    <?php foreach ($achievements as $achievement) : ?>
                                        <div class="achievement">
                                            <img src="<?php echo $achievement['cover'] ?>" alt="<?php echo $achievement['title'] ?>">
                                            <span><?php echo $achievement['title'] ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>

        <?php if (isset($_SESSION['userId']) && $_SESSION['userId'] != $_GET['id']) : ?>
            <div id="report-screen" style="display:none"> 
                <h1>Report this user</h1>
                <p id="close" onclick="closeReport()">X</p>
                <form action="" method="POST">
                    <label for="report-reason">Reason</label><br>
                    <select name="report-reason" id="report-reason">
                        <option value="spam">Spam</option>
                        <option value="inappropriate">Inappropriate</option>
                        <option value="other">Other</option>
                    </select>

                    <label for="report-description"><br><br>Description</label>
                    <textarea name="report-description" id="report-description" cols="30" rows="10"></textarea>

                    <input id="rpt-btn" type="submit" value="Report">
                </form>
            </div>
        <?php endif; ?>
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




    const forms = document.querySelectorAll('.formpost');
    forms.forEach(form => {
        form.addEventListener('submit', e => {
            e.preventDefault();
            let id = e.target.dataset.id;
            formdata = new FormData();
            formdata.append('id', id);
            
            if(e.submitter.name === 'add') {
                console.log('added this as mod');
                console.log(id);
                fetch('ajax/make-mod.ajax.php', {
                    method: 'POST',
                    body: formdata
                }) 
                .then(
                    response => response.json()) //.json veranderd json naar string in js die je kan gebruiken.
                .then(result => {
                    console.log(result);
                    if(result.status === 'success') {
                        e.target.parentElement.parentElement.remove();
                    }
                })
            }
        });
    });
</script>
</html>
