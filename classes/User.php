<?php

require_once(__DIR__ . "/Database.php");
require_once(__DIR__ . "/Email.php");

class User 
{
    private $username;
    private $password;
    private $email;


    // getters

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUsername(): string
    {
        return $this->username;
    }


    // setters

    public function setUsername(string $username)
    {
        if (preg_match('([^a-zA-Z0-9])', $username) === 1 || strlen($username) === 0) {
            throw new Exception("Usernames is not valid. Only letters and numbers allowed");
        }

        $this->username = $username;

        return $this;
    }

    public function setEmail(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email address is not valid.");
        }
        
        $this->email = $email;

        return $this;
    }

    public function setPassword(string $password)
    {
        if (strlen($password) <= 8) {
            throw new Exception("Your password does not meet the given criteria.");
        }
        
        $hash = password_hash($password, PASSWORD_DEFAULT, [ "cost" => 12 ]);

        $this->password = $hash;

        return $this;
    }


    // database

    public function insertUser() 
    {
        $PDO = Database::getInstance();
        $code = Email::generateVerificationCode();

        $stmt = $PDO->prepare("Insert into users (username, email, password, email_verification_code) values (:username, :email, :password, :code)");
        $stmt->bindValue(":username", $this->username);
        $stmt->bindValue(":email", $this->email);
        $stmt->bindValue(":password", $this->password);
        $stmt->bindValue(":code", $code);
        $success = $stmt->execute();

        if ($success == true) {
            return $success;
        } else {
            throw new Exception("Something went wrong. Try again later");
        }
    }


    // static functions

    public static function canLogin (string $password, string $email): bool
    {
        $PDO = Database::getInstance();
        $statement = $PDO->prepare("SELECT * FROM `users` WHERE email = :email AND active = 1");
        $statement->bindValue(":email", $email);
        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if ($user === false){
            return false;
        }

        if (password_verify($password, $user['password'])) {

            if ($user['email_verified'] == false) {
                throw new Exception("This account has not been activated. Please verify your email address. A link has been send.");
                return false;
            } else {
                return true;
            }

        } else {
            return false;
        }
    }

    public static function getUserById (int $id)
    {
        return "user lol";
    }

    public static function getUserByEmail (string $email): array
    {
        $PDO = Database::getInstance();
        $stmt = $PDO->prepare("SELECT * FROM `users` WHERE email = :email AND active = 1");
        $stmt->bindValue(":email", $email);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function verifyEmail (string $code): bool
    {
        $PDO = Database::getInstance();
        $stmt = $PDO->prepare("update users set email_verified = 1 where email_verification_code = :code");
        $stmt->bindValue(":code", $code);
        $stmt->execute();

        $count = $stmt->rowCount();
        return $count == 0 ? false : true;
    }
}