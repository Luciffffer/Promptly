<?php

    require_once(__DIR__ . "/../vendor/autoload.php");
    
    use Promptly\Core\User;
    use Promptly\Core\Report;
    use Promptly\Helpers\Security;

    Security::onlyModerator();

    $report = new Report();
    $reports = $report->getUserReports();
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
                <p class="prompt-images-title">Extra information</p>
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
                            <p class="prompt-title"><?php echo $report['extra_information'];?></p>
                            <div class="buttons">
                                <form class="formpost" action="" method="POST" data-id="<?php echo $report['id']?>">
                                    <input type="submit" id="btn-opmaak" class="button" value="Block" name="block">
                                    <input type="submit" id="btn-opmaak2" class="button" value="Ignore" name="ignore">
                                </form>
                            </div>
                    </div>
                        
                    
                    <?php
                    
                }
            ?>
        </div>
    </main>

    <script>
        // Zegher you can't delete all reports by a user. I changed it so it only deletes that specific report. You can make it so it deletes all reports of a specific reported account tho.

        const forms = document.querySelectorAll('.formpost');
        forms.forEach(form => {
        form.addEventListener('submit', e => {
            e.preventDefault();
            let id = e.target.dataset.id;
            formdata = new FormData();
            formdata.append('id', id);
            
            if(e.submitter.name === 'block') {
                console.log('block');
                console.log(id);
                fetch('../ajax/block-user.ajax.php', {
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
            } else if(e.submitter.name === 'ignore') {
                console.log('deny');
                console.log(id);
                fetch('../ajax/ignore-report.ajax.php', {
                    method: 'POST',
                    body: formdata
                }) 
                .then(
                    response => response.json())
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
</body>
</html>