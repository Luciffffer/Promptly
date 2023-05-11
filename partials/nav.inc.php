<nav id="primary-nav">
    <img id="hamburger-menu" src="<?php echo __ROOT__; ?>assets/images/site/hamburg-menu-icon.svg" alt="Hamburger menu button">
    <div class="logo-ul-container">
        <div class="logo-container">
            <img src="<?php echo __ROOT__; ?>assets/images/site/promptly-logo.svg" alt="Logo">
            <h3>Promptly</h3>
        </div>
        <ul aria-label="Primary navigation" id="nav-ul" class="hamburg-transform">
            <li><a class="white-a" href="<?php echo __ROOT__; ?>index">Home</a></li>
            <li><a class="white-a" href="<?php echo __ROOT__; ?>discover">Discover</a></li>
            <li><a class="white-a" href="<?php echo __ROOT__; ?>plans">Plans</a></li>
            <li id="search-bar-li"><input aria-label="Search bar" class="search-bar" type="text" placeholder="Search"></li>
        </ul>
    </div>

    <div class="account-nav" aria-label="Account navigation">

        <?php if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) : ?>

            <p class="credits hide-media-query">95 credits</p>
            <div style="position: relative;">
                <div class="white-a profile-a">
                    <span class="hide-media-query"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    <figure style="background-image: url(<?php echo __ROOT__ . htmlspecialchars($_SESSION['profile-pic']); ?>);"></figure>
                </div>
                <div id="account-nav-hitbox-login">
                    <ul id="account-nav-login" aria-label="Account navigation list">
                        <li><a class="white-a" href="<?php echo __ROOT__; ?>profile?id=<?php echo $_SESSION['userId']; ?>">Your profile</a></li>
                        <li><a class="white-a" href="<?php echo __ROOT__; ?>settings">Settings</a></li>
                        <li id="account-nav-logout"><a class="white-a" href="<?php echo __ROOT__; ?>logout">Log out</a></li>
                    </ul>
                </div>
            </div>
            <figure class="vertical-line hide-media-query"></figure>
            <a class="white-a hide-media-query" href="<?php echo __ROOT__; ?>logout">Log out</a>

        <?php else : ?>

            <figure id="not-login-profile-pic" ></figure>
            <div id="account-nav-hitbox">  
                <ul id="account-nav" aria-label="Account navigation list">
                    <li><a class="button primary-btn-white" id="primary-btn-nav" href="<?php echo __ROOT__; ?>login">Log in</a></li>
                    <li><a class="secondary-btn-white white-a" href="<?php echo __ROOT__; ?>register">Sign up</a></li>
                </ul>
            </div>

        <?php endif; ?>

    </div>
</nav>
<div id="nav-place-filler"></div>
<script src="<?php echo __ROOT__; ?>assets/js/primary-nav.js" defer></script>