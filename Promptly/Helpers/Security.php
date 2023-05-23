<?php

namespace Promptly\Helpers;

class Security
{
    public static function onlyNonLoggedIn(): void
    {
        session_start();
        if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) {
            header("location: http://". $_SERVER['HTTP_HOST'] . __ROOT__ . "index");
        }
    }

    public static function onlyLoggedIn(): void
    {
        session_start();
        if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] === false) {
            header("location: http://". $_SERVER['HTTP_HOST'] . __ROOT__ . "index");
        }
    }

    public static function onlyModerator()
    {
        session_start();
        if (!isset($_SESSION['isModerator']) || $_SESSION['isModerator'] === false) {
            header("location: http://". $_SERVER['HTTP_HOST'] . __ROOT__ . "index");
        }
    }
}
