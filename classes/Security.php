<?php

class Security {

    public static function onlyNonLoggedIn (): void
    {
        if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) {
            header("location: index");
        }
    }
}