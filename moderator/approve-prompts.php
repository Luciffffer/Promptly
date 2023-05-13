<?php
    include_once(__DIR__ . "/../classes/Prompt.php");
    include_once(__DIR__ . "/../classes/User.php"); 
    // include_once("../ajax/remove-prompt.ajax.php"); 

    $prompt = new Prompt();
    $prompts = $prompt->getPrompts(approved: 0);
   
    // if($_SESSION['isMod'] == false){
    //     header('location: ../index');
    // }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderation tool</title>
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
                <p class="prompt-model">Model ID</p>
                <p class="prompt-title-top">Title</p>
                <p class="prompt-images-title">Images</p>
                <p class="prompt-words">Words</p>
            </div>
            <?php 
                foreach($prompts as $prompt){
                    ?>
                    
                    <div class='prompt'>
                        <p class="prompt-model"><?php echo $prompt['model_id']?></p>
                        <div class="title-tags">
                            <p class="prompt-title"><?php echo $prompt['title']?></p>
                            <p class="prompt-tags"><?php echo $prompt['tags']?></p>
                        </div>
                        <div class="prompt-images">
                            <p class="img-prompt" style="background-image: url(../<?php echo $prompt['example_image1']; ?>)"></p>
                            <p class="img-prompt" style="background-image: url(../<?php echo $prompt['example_image2']; ?>)"></p>
                            <p class="img-prompt" style="background-image: url(../<?php echo $prompt['example_image3']; ?>)"></p>
                            <p class="img-prompt" style="background-image: url(../<?php echo $prompt['example_image4']; ?>)"></p>
                        </div>
                        <p class="prompt-words"><?php echo $prompt['word_count']?></p>
                        <div class="buttons">
                        <form class="formpost" action="" method="POST" data-id="<?php echo $prompt['id']?>">
                            <input type="submit" value="Approve" name="approve">
                            <input type="submit" value="Deny" name="deny">
                        </form>
                        </div>

                        </div>
                    
                    <?php
                }
            ?>
        </div>

        <script>
    const forms = document.querySelectorAll('.formpost');
    const formData = new FormData()
    formData.append('id', id)
    forms.forEach(form => {
        form.addEventListener('submit', e => {
            e.preventDefault();
            const id = e.target.dataset.id;
            if(e.submitter.name === 'approve') {
                console.log('approve');
                fetch('../ajax/approve-prompts.ajax.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'id=' + id
                    
                })
                .then(response => {
                    if (response.ok) {
                        console.log('Prompt approved successfully');
                        e.target.parentElement.parentElement.remove();
                    } else {
                        console.error('Error approving prompt');
                    }
                })
            } else if(e.submitter.name === 'deny') {
                console.log('deny');
                
                fetch('../ajax/remove-prompt.ajax.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'id=' + id
                })
                .then(response => {
                    if (response.ok) {
                        console.log('Prompt deleted successfully');
                        e.target.parentElement.parentElement.remove();
                    } else {
                        console.error('Error deleting prompt');
                    }
                })
                .catch(error => {
                    console.error('Error deleting prompt', error);
                });
            }
        });
    });
</script>
    </main>
</body>
</html>