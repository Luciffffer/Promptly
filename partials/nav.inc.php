<nav>
    <div class="logo-ul-container">
        <div class="logo-container">
            <img src="./assets/images/site/promptly-logo.svg" alt="Logo">
            <h3>Promptly</h3>
        </div>
        <ul aria-label="Primary navigation">
            <li><a class="white-a" href="index">Home</a></li>
            <li><a class="white-a" href="browse">Browse</a></li>
            <li><a class="white-a" href="plans">Plans</a></li>
        </ul>
    </div>

    <input aria-label="Search bar" class="search-bar" type="text" placeholder="Search">

    <div class="account-nav" aria-label="Account navigation">

        <?php if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) : ?>

            <p class="credits">95 credits</p>
            <a class="white-a profile-a" href="profile?id=<?php echo $_SESSION['userId']; ?>">
                <?php echo htmlspecialchars($_SESSION['username']); ?>
                <img src="<?php echo htmlspecialchars($_SESSION['profile-pic']); ?>" alt="Your profile picture">
            </a>
            <figure class="vertical-line"></figure>
            <a class="white-a" href="logout">Log out</a>

        <?php else : ?>

            <a class="button primary-btn-white" id="primary-btn-nav" href="login">Log in</a>
            <a class="secondary-btn-white white-a" href="register">Sign up</a>

        <?php endif; ?>

    </div>
</nav>