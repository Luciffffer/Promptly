<?php 

include_once(__DIR__ . "/classes/Prompt.php");

session_start();

$prompts = Prompt::getPrompts($_GET['order']);
$categories = Prompt::getAllCategories();
$models = Prompt::getAllModels();

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Prompts - Promptly</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="shortcut icon" href="assets/images/site/promptly-logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/platform.css">
</head>
<body>
    <?php include_once(__DIR__ . "/partials/nav.inc.php"); ?>
    <main>
        <?php include_once(__DIR__ . "/partials/aside.inc.php"); ?>
        <div style="padding: 0 3rem">
            <header id="all-prompts-header">
                <h1><span class="blue-text">All</span> Prompts</h1>
                <form action="" method="GET" id="all-prompts-form">
                    <div>
                        <div id="filter-btn-container">
                            <a data-filterBtn="models" href="#" class="filter-btn button">
                                <h3>Models</h3>
                                <img src="assets/images/site/arrow-right.svg" alt="Arrow right">
                            </a>
                            <a data-filterBtn="categories" href="#" class="filter-btn button">
                                <h3>Categories</h3>
                                <img src="assets/images/site/arrow-right.svg" alt="Arrow right">
                            </a>
                            <input data-input="categories" class="hidden" type="text" name="categories"></input>
                            <input data-input="models" class="hidden" type="text" name="models"></input>
                        </div>
                        <?php if (empty($_GET['categories']) && empty($_GET['models'])) : ?>
                            <select name="order" id="order" onchange="this.form.submit()">
                                <option value="popular" <?php if ($_GET['order'] == 'popular') echo 'selected'; ?>>Popular</option>
                                <option value="new" <?php if ($_GET['order'] == 'new') echo 'selected'; ?>>New</option>
                            </select>
                        <?php endif; ?>
                    </div>
                    <div data-filterDropdown="categories" class="filter-dropdown filter-dropdown-hidden hidden">
                        <div class="filter-dropdown-grid">
                            <?php foreach($categories as $category) : ?>
                                <span data-id="<?php echo $category['id']; ?>" <?php if (isset($_GET['categories']) && in_array($category['id'], explode(',', $_GET['categories']))) echo 'class="filter-dropdown-checked"' ?>>
                                    <?php echo $category['title']; ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                        <input class="primary-btn-white button" type="submit" value="Apply filters">
                    </div>
                    <div data-filterDropdown="models" class="filter-dropdown filter-dropdown-hidden hidden">
                        <div class="filter-dropdown-grid">
                            <?php foreach($models as $model) : ?>
                                <span data-id="<?php echo $model['id']; ?>" <?php if (isset($_GET['categories']) && in_array($model['id'], explode(',', $_GET['models']))) echo 'class="filter-dropdown-checked"' ?>>
                                    <?php echo $model['name']; ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                        <input class="primary-btn-white button" type="submit" value="Apply filters">
                    </div>
                    <?php if (isset($_GET['categories']) && !empty($_GET['categories'] || isset($_GET['models']) && !empty($_GET['models']))) : ?>
                        <small>Active filters:</small>
                        <div style="gap: 1rem">
                            <div id="active-filters-container">
                                <?php if (!empty($_GET['models'])) : // bro please tell me there is a better way wtf is this 😭😭😭😭😭😭?>

                                    <?php foreach ($models as $model) : ?>
                                        <?php if (in_array($model['id'], explode(",", $_GET['models']))) : ?>
                                            <span class="active-filter-model" data-id="<?php echo $model['id']; ?>">
                                                <?php echo $model['name']; ?>
                                                <img src="assets/images/site/cross-symbol-white.svg" alt="Delete filter">
                                            </span>
                                        <?php endif; ?>
                                    <?php endforeach; ?>

                                <?php endif; ?>
                                <?php if (!empty($_GET['categories'])) : ?>

                                    <?php foreach ($categories as $category) : ?>
                                        <?php if (in_array($category['id'], explode(",", $_GET['categories']))) : ?>
                                            <span data-id="<?php echo $category['id']; ?>">
                                                <?php echo $category['title']; ?>
                                                <img src="assets/images/site/cross-symbol-white.svg" alt="Delete filter">
                                            </span>
                                        <?php endif; ?>
                                    <?php endforeach; ?>

                                <?php endif; ?>
                            </div>
                            <select name="order" id="order" onchange="this.form.submit()">
                                <option value="popular" <?php if ($_GET['order'] == 'popular') echo 'selected'; ?>>Popular</option>
                                <option value="new" <?php if ($_GET['order'] == 'new') echo 'selected'; ?>>New</option>
                            </select>
                        </div>
                    <?php endif; ?>
                </form>
                <script>
                    // check children of filter dropdowns
                    document.querySelectorAll(".filter-dropdown-grid").forEach(dropdownGrid => {
                        dropdownGrid.addEventListener("click", e => {
                            if (e.target !== e.currentTarget) {
                                e.target.classList.toggle("filter-dropdown-checked");
                                setInputValues();
                            }
                        });
                    });

                    // set input values
                    function setInputValues() {
                        const categoriesInput = document.querySelector("[data-input='categories']");
                        const modelsInput = document.querySelector("[data-input='models']");
                        const categoriesChecked = document.querySelectorAll("[data-filterDropdown='categories'] .filter-dropdown-checked");
                        const modelsChecked = document.querySelectorAll("[data-filterDropdown='models'] .filter-dropdown-checked");
                        let categoriesValue = "";
                        let modelsValue = "";

                        categoriesChecked.forEach((category, i) => {
                            categoriesValue += category.dataset.id;
                            if (i < categoriesChecked.length - 1) categoriesValue += ",";
                        });
                        modelsChecked.forEach((model, i) => {
                            modelsValue += model.dataset.id;
                            if (i < modelsChecked.length - 1) modelsValue += ",";
                        });

                        categoriesInput.value = categoriesValue;
                        modelsInput.value = modelsValue;
                    }

                    setInputValues();

                    // show/hide filter dropdowns
                    document.querySelector("#filter-btn-container").addEventListener("click", e => {
                        if (e.target.classList.contains("filter-btn")) {
                            e.preventDefault();
                            const dropdown = document.querySelector(`[data-filterDropdown="${e.target.dataset.filterbtn}"]`);
                            const input = document.querySelector(`[data-input="${e.target.dataset.filterbtn}"]`);
                            const arrow = e.target.querySelector(`[data-filterBtn="${e.target.dataset.filterbtn}"] > img`);

                            if (dropdown.classList.contains("filter-dropdown-hidden")) {

                                dropdown.classList.remove("hidden");
                                setTimeout(() => {
                                    dropdown.classList.remove("filter-dropdown-hidden");
                                }, 20);
                                arrow.classList.add("filter-btn-open");

                            } else {

                                dropdown.classList.add("filter-dropdown-hidden");
                                dropdown.addEventListener("transitionend", function() {
                                    dropdown.classList.add("hidden");
                                }, {
                                    once: true
                                });
                                arrow.classList.remove("filter-btn-open");

                            }
                        }
                    });

                    // delete active filters
                    const activeFiltersContainer = document.querySelector("#active-filters-container");

                    if (activeFiltersContainer) {
                        activeFiltersContainer.addEventListener("click", e => {
                            if (e.target.tagName === "IMG") {
                                const filter = e.target.parentElement;
                                const filterType = filter.classList.contains("active-filter-model") ? "models" : "categories";
                                const filterId = filter.dataset.id;
                                const filterDropdown = document.querySelector(`[data-filterDropdown="${filterType}"]`);
                                const filterDropdownChecked = filterDropdown.querySelector(`[data-id="${filterId}"]`);

                                filterDropdownChecked.classList.remove("filter-dropdown-checked");
                                setInputValues();
                                document.querySelector("#all-prompts-form").submit();
                            }
                        })
                    }

                </script>
            </header>
            <hr class="grey-hr">
            <section aria-label="Prompt list" id="all-prompts-list">
                <?php //var_dump($prompts); ?>
                <?php foreach ($prompts as $prompt) : ?>

                    <div>
                        <div class="prompt-card-header" style="background-image: url(<?php echo $prompt['header_image']; ?>)">
                            <div class="prompt-card-header-model">

                            </div>
                        </div>
                        <div class="prompt-card-body">
                            <div class="prompt-card-body-left">
                                <h3><?php echo $prompt['title']; ?></h3>
                                <div>

                                </div>
                            </div>
                            <a href="#">
                                <img src="assets/images/site/plus-circle-icon.svg" alt="">
                            </a>
                        </div>
                    </div>

                <?php endforeach; ?>
            </section>
        </div>
    </main>
</body>
</html>