<?php

class Security {
    public static function onlyNonLoggedIn (): void
    {
        session_start();
        if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) {
            header("location: http://". $_SERVER['HTTP_HOST']. "/php/promptly/index");
        }
    }

    public static function onlyLoggedIn (): void
    {
        session_start();
        if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] === false) {
            header("location: http://". $_SERVER['HTTP_HOST']. "/php/promptly/index");
        }
    }
}