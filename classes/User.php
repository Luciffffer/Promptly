<?php

require_once(__DIR__ . "/Database.php");
require_once(__DIR__ . "/Security.php");

class User 
{
    private $username;
    private $password;
    private $email;
    private $verificationCode;


    // getters

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getVerificationCode(): string
    {
        return $this->verificationCode;
    }


    // setters

    public function setUsername(string $username)
    {
        if (preg_match('([^a-zA-Z0-9])', $username) === 1 || strlen($username) === 0) {
            throw new Exception("Usernames is not valid. Only letters and numbers allowed");
        } elseif (!$this->checkUnique("username", $username)) {
            throw new Exception("This username is already taken.");
        }

        $this->username = $username;

        return $this;
    }

    public function setEmail(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email address is not valid.");
        } elseif (!$this->checkUnique("email", $email)) {
            throw new Exception("An account with this email address already exists.");
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


    // Check if certain value is unique or already in the database.
    private function checkUnique($columnName, $value): bool
    {
        $PDO = Database::getInstance();

        $stmt = $PDO->prepare("select * from users where $columnName = :columnValue");
        $stmt->bindValue(":columnValue", $value);
        $stmt->execute();
        $result = $stmt->fetch();

        return $result === false ? true : false;
    }

    public function generateVerificationCode ($modifier): string
    {
        $PDO = Database::getInstance();
        $unique = false;

        while ($unique === false) {
            $token = Security::generateToken($modifier);

            $stmt = $PDO->prepare("select * from users where email_verification_code = :code");
            $stmt->bindValue(":code", $token);
            $stmt->execute();

            if ($stmt->fetch() == false) {
                $unique = true;
                $this->verificationCode = $token;
                
                return $this;
            }
        }
    }

    public function insertUser(): bool
    {
        $PDO = Database::getInstance();
        $code = $this->verificationCode;

        // insert user
        $stmt = $PDO->prepare("Insert into users (username, email, password, email_verification_code) values (:username, :email, :password, :code)");
        $stmt->bindValue(":username", $this->username);
        $stmt->bindValue(":email", $this->email);
        $stmt->bindValue(":password", $this->password);
        $stmt->bindValue(":code", $code);
        $success = $stmt->execute();

        if (!$success) {
            throw new Exception("Something went wrong. Try again later");
        }

        return $success;
        
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

                $stmt = $PDO->prepare("UPDATE users SET last_login = NOW() WHERE email = :email");
                $stmt->bindValue(":email", $email);
                $stmt->execute();

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

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (empty($result)) {
            throw new Exception("User with this email does not exist.");
        }
        
        return $result;
    }

    public static function verifyEmail (string $code): bool
    {
        $PDO = Database::getInstance();

        // check if there is a user with this code that has already been verified
        $stmt2 = $PDO->prepare("select * from users where email_verified = 1 and email_verification_code = :code");
        $stmt2->bindValue(":code", $code);
        $stmt2->execute();
        $result = $stmt2->fetch();

        // update email verified if there is a user with this code that has not been verified yet
        $stmt = $PDO->prepare("update users set email_verified = 1 where email_verification_code = :code");
        $stmt->bindValue(":code", $code);
        $stmt->execute();
        $count = $stmt->rowCount();

        return $count == 0 && $result == false ? false : true;
    }
}