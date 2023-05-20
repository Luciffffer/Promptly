<?php
    include_once(__DIR__ . "/../classes/User.php");
    include_once(__DIR__ . "/../classes/Report.php");
    include_once(__DIR__ . "/../classes/Security.php");

    Security::onlyModerator();

    $report = new Report();
    $reports = $report->getReports();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reported users - MOD TOOL</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="shortcut icon" href="../assets/images/site/promptly-logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="../css/platform.css">
    <link rel="stylesheet" href="../moderator/moderator.css">
</head>
<body>
<?php include_once(__DIR__ . "/../partials/nav.inc.php"); ?>
    <main>
        <?php include_once(__DIR__."/../partials/aside.inc.php");?>

        <div class="all-none-approved">
            <div class='prompt'>
                <p class="prompt-model">Reported user</p>
                <p class="prompt-model">By</p>
                <p class="prompt-title-top">Reason</p>
                <p class="prompt-images-title">Description</p>
                <p class="prompt-words">Verdict</p>
            </div>
            <?php 
                foreach($reports as $report){
            ?>                
                    <div class='prompt'>
                        <a href="../profile?id=<?php echo $report['user_id']?>">
                            <p class="prompt-model"><?php echo $report['user_id']?></p>
                        </a>
                            <p class="prompt-title"><?php echo $report['reporter_id']?></p>
                            <p class="prompt-title"><?php echo $report['reason'];?></p>
                            <p class="prompt-title"><?php echo $report['description'];?></p>
                            <div class="buttons">
                                <form class="formpost" action="" method="POST" data-id="<?php echo $prompt['id']?>">
                                    <input type="submit" id="btn-opmaak" class="button" value="Approve" name="approve">
                                    <input type="submit" id="btn-opmaak2" class="button" value="Deny" name="deny">
                                </form>
                            </div>
                    </div>
                        
                    
                    <?php
                }
            ?>
        </div>
    </main>
</body>
</html>