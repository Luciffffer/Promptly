<nav id="primary-nav">
    <img id="hamburger-menu" src="./assets/images/site/hamburg-menu-icon.svg" alt="Hamburger menu button">
    <div class="logo-ul-container">
        <div class="logo-container">
            <img src="./assets/images/site/promptly-logo.svg" alt="Logo">
            <h3>Promptly</h3>
        </div>
        <ul aria-label="Primary navigation" id="nav-ul" class="hamburg-transform">
            <li><a class="white-a" href="index">Home</a></li>
            <li><a class="white-a" href="browse">Browse</a></li>
            <li><a class="white-a" href="plans">Plans</a></li>
            <li id="search-bar-li"><input aria-label="Search bar" class="search-bar" type="text" placeholder="Search"></li>
        </ul>
    </div>

    <div class="account-nav" aria-label="Account navigation">

        <?php if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) : ?>

            <p class="credits hide-media-query">95 credits</p>
            <a class="white-a profile-a" href="profile?id=<?php echo $_SESSION['userId']; ?>">
                <span class="hide-media-query"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                <img src="<?php echo htmlspecialchars($_SESSION['profile-pic']); ?>" alt="Your profile picture">
            </a>
            <figure class="vertical-line hide-media-query"></figure>
            <a class="white-a hide-media-query" href="logout">Log out</a>

        <?php else : ?>

            <a class="button primary-btn-white" id="primary-btn-nav" href="login">Log in</a>
            <a class="secondary-btn-white white-a" href="register">Sign up</a>

        <?php endif; ?>

    </div>
</nav>
<div id="nav-place-filler"></div>
<script src="./assets/js/primary-nav.js" defer></script>