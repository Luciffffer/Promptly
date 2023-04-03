<?php

require_once(__DIR__ . "/Database.php");

class User {
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
        if (!str_contains($email, "@") || !str_contains($email, ".") || strlen($email) === 0) {
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

        $stmt = $PDO->prepare("Insert into users (username, email, password) values (:username, :email, :password)");
        $stmt->bindValue(":username", $this->username);
        $stmt->bindValue(":email", $this->email);
        $stmt->bindValue(":password", $this->password);
        $success = $stmt->execute();

        if ($success == true) {
            return $success;
        } else {
            throw new Exception("Something went wrong. Try again later");
        }
    }


    // static functions

    public static function getUserById (int $id)
    {
        return "user lol";
    }
}