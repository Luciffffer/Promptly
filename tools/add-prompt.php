<?php 

include_once(__DIR__ . "/../classes/Security.php");
include_once(__DIR__ . "/../classes/Prompt.php");
include_once(__DIR__ . "/../classes/File.php");
include_once(__DIR__ . "/../classes/Achievement.php");

Security::onlyLoggedIn();

$models = Prompt::getAllModels();
$categories = Prompt::getAllCategories();

if (!empty($_POST) && !empty($_FILES)) {
    try {

        if (sizeof($_FILES) > 5) {
            throw new Exception("Max 5 images allowed to upload. Structure: header-image, example-image-1, example-image-2, example-image-3, example-image-4");
        }

        $prompt = new Prompt();

        // set model information
        $prompt->setModelId($_POST['model']);
        $prompt->setModelVersion($_POST['model-version']);

        // set basic information
        $prompt->setTitle($_POST['title']);
        $prompt->setAuthorId($_SESSION['userId']);
        $prompt->setDescription($_POST['description']);

        $prompt->setTags($_POST['tags']);
        $prompt->setCategories($_POST['categories']);

        // set prompt information
        $prompt->setPrompt($_POST['prompt']);
        $prompt->setPromptInstructions($_POST['instructions']);

        // set is prompt free?
        if (isset($_POST['free'])) $prompt->setIsFree(true); else $prompt->setIsFree(false);

        // set images
        foreach ($_FILES as $key => $file) {
            $img = new File();
            $img->setImageName($file['name']);
            $img->validateImageSize($file['size']);
            
            $path = $img->getPath();

            switch ($key) {
                case "header-image":
                    $prompt->setHeaderImage($path);
                    break;
                case "prompt-example-image1":
                    $prompt->setExampleImage1($path);
                    break;
                case "prompt-example-image2":
                    $prompt->setExampleImage2($path);
                    break;
                case "prompt-example-image3":
                    $prompt->setExampleImage3($path);
                    break;
                case "prompt-example-image4":
                    $prompt->setExampleImage4($path);
                    break;
                default:
                    throw new Exception("Use following structure for the images: header-image, example-image-1, example-image-2, example-image-3, example-image-4");
            }

            $img->moveImage($file['tmp_name']);
        }

        $prompt->insertPrompt();

        $prompts = Prompt::getPromptsByUserId($_SESSION['userId']);

        if (count($prompts) === 1) {
            Achievement::unlockAchievement(2, $_SESSION['userId']);
        }

        header("Location: ../prompt?id=" . $prompts[0]['id']);

    } catch (Throwable $err) {
        $error = $err->getMessage();
    }
}

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
        <form action="" method="POST" enctype="multipart/form-data">
            <label id="prompt-header" for="prompt-header-image">
                <div class="hidden"></div>
                <i></i>
            </label>
            <input data-type="image" type="file" name="header-image" id="prompt-header-image" accept=".jpg, .jpeg, .png, .webp" class="hidden">
            <script src="../assets/js/prompt-header-parallax.js" defer></script>
            <div class="center-parent">
                <div class="center" id="single-prompt-grid">
                    <div>
                        
                        <?php if (isset($error)) : ?>
                            <section id="error-section">
                                <h3>Error: <?php echo $error ?></h3>
                                <img src="../assets/images/site/warning-icon.svg" alt="Warning icon">
                            </section>
                        <?php endif; ?>

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
                            <div style="position: relative; margin-top: 1rem; margin-bottom: 2rem">
                                <input id="title-input" type="text" name="title" placeholder="Add a Title..." value="<?php if (isset($error)) echo $_POST['title']; ?>">
                                <hr id="title-input-front-hr">
                                <hr id="title-input-bg-hr">
                            </div>
                            <div class="form-part" style="position: relative;">
                                <fieldset>
                                    <legend>Categories</legend>
                                    <label id="categories-label">
                                        <input type="text" name="categories" placeholder="Please select..." class="hidden">
                                        <span id="categories-span">
                                        </span>
                                    </label>
                                </fieldset>
                                <small>You can select multiple categories but try to keep the category count as low as possible.</small>
                                <select id="categories-select" class="hidden-size" multiple>
                                    <?php foreach($categories as $category) : ?>
                                        <option value="<?php echo $category['id']; ?>">
                                            <?php echo $category['title']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <script src="../assets/js/category-select.js" type="application/javascript"></script>
                            </div>
                            <div class="form-part">
                                <fieldset>
                                    <legend>Tags</legend>
                                    <textarea class="grey-textarea" name="tags" id="tags" cols="30" rows="1" placeholder="Add keywords that describe your prompt"><?php if (isset($error)) echo $_POST['tags']; ?></textarea>
                                </fieldset>
                                <small>Separate by a comma.</small> 
                            </div>
                            <div class="form-part">
                                <fieldset>
                                    <legend>Description</legend>
                                    <textarea class="grey-textarea" name="description" id="description" placeholder="Add a comprehensive description" cols="30" rows="10"><?php if (isset($error)) echo $_POST['description']; ?></textarea>
                                </fieldset>
                            </div>   
                            <div class="form-part" id="free-form-part">
                                <p>When you post your prompt it will cost 1 credit for other users to get. If someone gets your prompt you will receive that credit and you can use it on other prompts for yourself. Check the box below if you want to make this prompt free and thus not receive credits for it.</p>
                                <input type="checkbox" name="free" id="free">
                                <label for="free">Make my prompt free</label>
                            </div>
                        </section>
                        <section id="prompt-author-info">
                            <p class="grey">Created: <?php echo date("F jS, o"); ?></p>
                            <a class="white-a profile-a" href="../profile?id=<?php echo $_SESSION['userId']; ?>">
                                <span class="grey">By:</span>
                                <figure style="background-image: url(../<?php echo $_SESSION['profile-pic'] ?>);"></figure>
                                <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                            </a>
                        </section>
                        <section id="prompt-section">
                            <h2>The <span class="blue-text">Prompt:</span></h2>
                            <textarea class="grey-textarea" name="prompt" id="prompt" cols="30" rows="5" placeholder="Place your prompt here..."><?php if (isset($error)) echo $_POST['prompt']; ?></textarea>
                            <script>
                                document.querySelector("#prompt").addEventListener('keyup', e => {
                                    const wordCount = document.querySelector("#prompt").value.match(/\S+/g) === null ? 0 : document.querySelector("#prompt").value.match(/\S+/g).length
                                    
                                    document.querySelector("#word-count").innerHTML = wordCount
                                })
                            </script>
                            <h3>Instructions:</h3>
                            <p>Write some comprehensive and easy to understand instructions on how to use the prompt. The goal is to make it as easy as possible for the user.</p>
                            <textarea class="grey-textarea" name="instructions" id="instructions" cols="30" rows="10" placeholder="To use this prompt..."><?php if (isset($error)) echo $_POST['instructions']; ?></textarea>
                        </section>
                        <div class="form-part" id="submit-form-part">
                            <p>When you post your prompt it will be send to a moderator for approval. Once approved, you will get a notification and it will be made public.</p>
                            <input class="primary-btn button" type="submit" value="Post my Prompt">
                        </div>
                    </div>
                    <section>
                        <div id="example-image-container">
                            <input data-type="image" type="file" name="prompt-example-image1" id="prompt-example-image1" accept=".jpg, .jpeg, .png, .webp" class="hidden"> 
                            <label for="prompt-example-image1" class="add-prompt-example-image"></label>
                        </div>
                        <a href="#" id="add-example-image"></a>
                    </section>
                </div>
            </div>
        </form>
    </main>
</body>
</html>