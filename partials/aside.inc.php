<?php 

include_once($_SERVER['DOCUMENT_ROOT'] . __ROOT__ . 'classes/Prompt.php');

$models = Prompt::getAllModels();

?><aside>
    <nav aria-label="Platform/tab navigator" id="aside-nav">
        <a class="button primary-btn-white" href="<?php echo __ROOT__; ?>tools/add-prompt">
            <img src="<?php echo __ROOT__; ?>/assets/images/site/plus-icon.svg" alt="Icon of a plus">
            <span>Add Prompt</span>
        </a>
        <div>
            <a href="<?php echo __ROOT__; ?>discover" class="aside-title">
                <img src="<?php echo __ROOT__ ;?>/assets/images/site/home-icon.svg" alt="Home icon">
                <h2>Browse</h2>
            </a>
            <ul class="aside-ul">
                <li><a href="<?php echo __ROOT__; ?>discover">Discover</a></li>
                <li><a href="#">Popular</a></li>
                <li><a href="#">New</a></li>
            </ul>
        </div>
        <div id="aside-models">
            <div class="aside-title">
                <img src="<?php echo __ROOT__ ;?>/assets/images/site/robot-icon.svg" alt="Model icon">
                <h2>Models</h2>
            </div>
            <ul class="aside-ul">
                <?php foreach ($models as $model) : ?>
                    <li><a href="#"><?php echo $model['name']; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div>
            <a href="#" class="aside-title">
                <img src="<?php echo __ROOT__ ;?>/assets/images/site/library-icon.svg" alt="Library icon">
                <h2>Library</h2>
            </a>
            <ul class="aside-ul">
                <li><a href="#">Bought</a></li>
                <li><a href="#">Liked</a></li>
                <li><a href="#">Your Prompts</a></li>
            </ul>
        </div>
    </nav>
</aside>
<div id="aside-placeholder"></div>
