<?php 
    require_once(__DIR__ . "/../vendor/autoload.php");
    
    use Promptly\Core\User;
    use Promptly\Core\Report;
    use Promptly\Helpers\Security;

    Security::onlyModerator();

    $blocks = new User();
    $blocks = $blocks->getModerators();
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remove MODS - MOD TOOL</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="shortcut icon" href="../assets/images/site/promptly-logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="../css/platform.css">
    <link rel="stylesheet" href="../moderator/moderator.css">
</head>
<body>
<?php include_once(__DIR__ . "/../partials/nav.inc.php"); ?>
    <main>
        <?php include_once(__DIR__."/../partials/aside.inc.php");?>

        <div>
            <div class="show-moderators-grid">
                <p>Names</p>
                <p>Verdict</p>
            </div>
            <div id="line"></div>

            <div>
                <?php 
                    foreach($blocks as $block){
                ?>     
                <div class="information-mods">
                    <a href="../profile?id=<?php echo $block['id'];?>">
                        <p><?php echo htmlspecialchars($block['username']);?></p>
                    </a>
                    <div class="buttons">
                        <form class="formpost" action="" method="POST" data-id="<?php echo $block['id']?>">
                            <input type="submit" id="btn-opmaak" class="button" value="Remove as MOD" name="remove">
                        </form>
                    </div>
                </div>
                    
                <?php
                    }
                ?>
            </div>
        </div>
        
    </main>
</body>
<script>
    const forms = document.querySelectorAll('.formpost');
        forms.forEach(form => {
        form.addEventListener('submit', e => {
            e.preventDefault();
            let id = e.target.dataset.id;
            formdata = new FormData();
            formdata.append('id', id);
            
            if(e.submitter.name === 'remove') {
                console.log('remove mod');
                console.log(id);
                fetch('../ajax/removeModerator.ajax.php', {
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