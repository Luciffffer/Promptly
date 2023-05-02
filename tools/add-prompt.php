<?php 

include_once(__DIR__ . "/../classes/Security.php");
include_once(__DIR__ . "/../classes/Prompt.php");

Security::onlyLoggedIn();

$models = Prompt::getAllModels();

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a Prompt - Promptly</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="shortcut icon" href="../assets/images/site/promptly-logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="../css/platform.css">
    <link rel="stylesheet" href="../css/single-prompt.css">
    <script src="../assets/js/add-prompt-images.js" defer></script>
</head>
<body>
    <?php include_once(__DIR__ . "/../partials/nav.inc.php"); ?>
    <main>
        <?php include_once(__DIR__ . "/../partials/aside.inc.php"); ?>
        <div>
            <label for="prompt-header-image">
                <header id="prompt-header">
                    <div class="hidden"></div>
                    <i></i>
                </header>
            </label>
            <input type="file" name="prompt-header-image" id="prompt-header-image" accept=".jpg, .jpeg, .png, .webp" class="hidden">
            <script src="../assets/js/prompt-header-parallax.js" defer></script>
            <div style="padding: 0 3rem">
                <div class="center" id="single-prompt-grid">
                    <div>
                        <form action="" method="POST">
                            <section id="single-prompt-top">
                                <p id="single-prompt-top-left">
                                    <span><span id="word-count">0</span> words</span>
                                </p>
                                <div>
                                    <select name="model" id="model">
                                        <?php foreach($models as $model) : ?>
                                            <option value="<?php echo $model['id']; ?>">
                                                <?php echo $model['name']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>

                                    <select name="model-version" id="model-version">
                                        <?php foreach(json_decode($models[0]['versions']) as $version) : ?>
                                            <option value="<?php echo $version; ?>">
                                                <?php echo $version; ?>
                                            </option>
                                        <?php endforeach ?>
                                    </select>
                                    <script>
                                        document.querySelector("#model").onchange = () => {
                                            const formData = new FormData();
                                            formData.append("modelId", document.querySelector("#model").value);

                                            fetch("../ajax/get-model-versions.ajax.php", {
                                                method: "POST",
                                                body: formData
                                            })
                                                .then(response => response.json())
                                                .then(json => {
                                                    document.querySelector("#model-version").innerHTML = '';

                                                    json['body'].forEach(version => {
                                                        const option = document.createElement("option");
                                                        option.value = version;
                                                        option.innerHTML = version;
                                                        document.querySelector("#model-version").appendChild(option);
                                                    })
                                                })
                                                .catch(err => {
                                                    console.error(err);
                                                })
                                        }
                                    </script>
                                </div>
                            </section>
                            <section>
                                <div style="position: relative; margin-bottom: 1rem">
                                    <input id="title-input" type="text" name="title" placeholder="Add a Title...">
                                    <hr id="title-input-front-hr">
                                    <hr id="title-input-bg-hr">
                                </div>
                                <div class="form-part">
                                    <fieldset>
                                        <legend>Tags</legend>
                                        <textarea class="grey-textarea" name="tags" id="tags" cols="30" rows="1" placeholder="Add keywords that describe your prompt"></textarea>
                                    </fieldset>
                                    <small>Separate by a comma or space.</small> 
                                </div>
                                <div class="form-part">
                                    <fieldset>
                                        <legend>Description</legend>
                                        <textarea class="grey-textarea" name="description" id="description" placeholder="Add a comprehensive description" cols="30" rows="10"></textarea>
                                    </fieldset>
                                </div>   
                            </section>
                            <section id="prompt-author-info">
                                <p class="grey">Created: now :P</p>
                                <a class="white-a profile-a" href="../profile?id=<?php echo $_SESSION['userId']; ?>">
                                    <span class="grey">By:</span>
                                    <figure style="background-image: url(../<?php echo $_SESSION['profile-pic'] ?>);"></figure>
                                    <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                                </a>
                            </section>
                            <section id="prompt-section">
                                <h2>The prompt:</h2>
                                <textarea class="grey-textarea" name="prompt" id="prompt" cols="30" rows="5"></textarea>
                                <script>
                                    document.querySelector("#prompt").addEventListener('keyup', e => {
                                        const wordCount = document.querySelector("#prompt").value.match(/\S+/g) === null ? 0 : document.querySelector("#prompt").value.match(/\S+/g).length
                                        
                                        document.querySelector("#word-count").innerHTML = wordCount
                                    })
                                </script>
                            </section>
                        </form>
                    </div>
                    <section>
                        <label for="prompt-example-image1" class="add-prompt-example-image"></label>
                        <input type="file" name="prompt-example-image1" id="prompt-example-image1" accept=".jpg, .jpeg, .png, .webp" class="hidden"> 
                        <label for="prompt-example-image1" class="add-prompt-example-image add-prompt-another-image"></label>
                        <input type="file" name="prompt-example-image1" id="prompt-example-image1" accept=".jpg, .jpeg, .png, .webp" class="hidden">
                    </section>
                </div>
            </div>
        </div>
    </main>
</body>
</html>