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
            <div style="position: relative" data-dropdown class="dropdown">
                <button id="notifications-btn" data-dropdown-btn></button>
                <div id="notifications-container">
                    <div id="notifications-top">
                        <p>Notifications</p>
                        <hr>
                    </div>
                    <div id="notifications-list">
                        <div class="notification">
                            <figure></figure>
                            <div>
                                <p>New achievement: Welcome to Promptly!</p>
                                <small>2 hours ago</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="position: relative;" data-dropdown class="dropdown">
                <button class="white-a profile-a" id="account-nav-btn" style="background-image: url(<?php echo __ROOT__ . htmlspecialchars($_SESSION['profile-pic']); ?>);" data-dropdown-btn></button>
                <div id="account-nav-hitbox-login">
                    <div id="account-nav-profile-info">
                        <figure style="background-image: url(<?php echo __ROOT__ . htmlspecialchars($_SESSION['profile-pic']); ?>)" aria-label="Profile pic"></figure>
                        <div>
                            <p><?php echo htmlspecialchars($_SESSION['username']); ?></p>
                            <small class="credits">95 credits</small>
                        </div>
                    </div>
                    <hr>
                    <ul id="account-nav-login" aria-label="Account navigation list">
                        <li><a class="white-a" href="<?php echo __ROOT__; ?>profile?id=<?php echo $_SESSION['userId']; ?>">
                            <img src="<?php echo __ROOT__; ?>assets/images/site/account-icon.svg" alt="Profile icon">
                            <span>Your profile</span>
                        </a></li>
                        <li><a class="white-a" href="<?php echo __ROOT__; ?>settings">
                            <img src="<?php echo __ROOT__; ?>assets/images/site/settings-icon.svg" alt="Settings icon">
                            <span>Settings</span>
                        </a></li>
                        <li id="account-nav-logout"><a class="white-a" href="<?php echo __ROOT__; ?>logout">
                            <img src="<?php echo __ROOT__; ?>assets/images/site/logout-icon.svg" alt="Logout icon">
                            <span>Log out</span>
                        </a></li>
                    </ul>
                    <?php if (isset($_SESSION['isModerator']) && $_SESSION['isModerator'] === true) : ?>
                        <hr>
                        <a href="#" id="account-nav-mod-btn">
                            <img src="<?php echo __ROOT__; ?>assets/images/site/shield-icon.svg" alt="Shield">
                            <span>Moderator section</span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

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