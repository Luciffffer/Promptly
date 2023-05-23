<?php 

require_once(__DIR__ . '/../vendor/autoload.php');

use Promptly\Core\Prompt;

$navModels = Prompt::getAllModels();

?><aside>
    <nav aria-label="Platform/tab navigator" id="aside-nav">
        <a class="button primary-btn-white" href="<?php echo __ROOT__; ?>tools/add-prompt">
            <img src="<?php echo __ROOT__; ?>assets/images/site/plus-icon.svg" alt="Icon of a plus">
            <span>Add Prompt</span>
        </a>
        <div>
            <a href="<?php echo __ROOT__; ?>discover" class="aside-title">
                <img src="<?php echo __ROOT__ ;?>assets/images/site/home-icon.svg" alt="Home icon">
                <h2>Browse</h2>
            </a>
            <ul class="aside-ul">
                <li><a href="<?php echo __ROOT__; ?>discover">Discover</a></li>
                <li><a href="<?php echo __ROOT__; ?>all-prompts?order=popular">Popular</a></li>
                <li><a href="<?php echo __ROOT__; ?>all-prompts?order=new">New</a></li>
            </ul>
        </div>
        <div id="aside-models">
            <div class="aside-title">
                <img src="<?php echo __ROOT__ ;?>assets/images/site/robot-icon.svg" alt="Model icon">
                <h2>Models</h2>
            </div>
            <ul class="aside-ul">
                <?php foreach ($navModels as $navModel) : ?>
                    <li><a href="<?php echo __ROOT__; ?>all-prompts?order=popular&models=<?php echo $navModel['id']; ?>"><?php echo $navModel['name']; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div>
            <a href="<?php echo __ROOT__; ?>library.php" class="aside-title">
                <img src="<?php echo __ROOT__ ;?>assets/images/site/library-icon.svg" alt="Library icon">
                <h2>Library</h2>
            </a>
            <ul class="aside-ul">
                <li><a href="<?php echo __ROOT__; ?>library.php?page=bought">Bought</a></li>
                <li><a href="<?php echo __ROOT__; ?>library.php?page=liked">Liked</a></li>
                <li><a href="<?php echo __ROOT__; ?>library.php?page=yours">Your Prompts</a></li>
            </ul>
        </div>
    </nav>
</aside>
<div id="aside-placeholder"></div>
