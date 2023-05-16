<?php
    include_once(__DIR__ . "/../classes/Prompt.php");
    include_once(__DIR__ . "/../classes/User.php");
    include_once(__DIR__ . "/../classes/Security.php"); 
    // include_once("../ajax/remove-prompt.ajax.php"); 
    session_start();
    Security::onlyModerator();

    $prompt = new Prompt();
    $prompts = $prompt->getPrompts(approved: 0);
   
    
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
                    $tags = json_decode($prompt['tags']); ?>                
                    <div class='prompt'>
                            <p class="prompt-model"><?php echo $prompt['model_id']?></p>
                            <div class="title-tags">
                                <p class="prompt-title"><?php echo $prompt['title']?></p>
                                <?php foreach($tags as $tag){ ?>
                                    <p class="prompt-tags"><?php echo $tag?></p>
                                <?php } ?>
                                <p class="prompt-tags"><?php json_decode($prompt['tags'])?></p>
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
                            <input type="submit" id="btn-opmaak" value="Approve" name="approve">
                            <input type="submit" id="btn-opmaak" value="Deny" name="deny">
                        </form>
                        </div>

                        </div>
                    
                    <?php
                }
            ?>
        </div>

        <script>
    const forms = document.querySelectorAll('.formpost');
    
    forms.forEach(form => {
        form.addEventListener('submit', e => {
            e.preventDefault();
            let id = e.target.dataset.id;
            formdata = new FormData();
            formdata.append('id', id);
            
            if(e.submitter.name === 'approve') {
                console.log('approve');
                console.log(id);
                fetch('../ajax/approve-prompts.ajax.php', {
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
            } else if(e.submitter.name === 'deny') {
                console.log('deny');
                console.log(id);
                fetch('../ajax/remove-prompt.ajax.php', {
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
    </main>
</body>
</html>