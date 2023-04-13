<?php

class Security {
    public static function generateToken (string $modifier = ""): string
    {
        $randomHex = bin2hex(random_bytes(100));
        $token = md5($randomHex . time() . $modifier);

        return $token;
    }
}