<?php

require_once(__DIR__ . "/Database.php");

class User 
{
    private $id;
    private $username;
    private $password;
    private $email;
    private $biography;
    private $profileImg;


    // getters

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getBiography(): string
    {
        return $this->biography;
    }


    // setters

    public function setId (int $id)
    {
        $this->id = $id;
        return $this;
    }

    public function setUsername (string $username)
    {
        if (preg_match('([^a-zA-Z0-9])', $username) === 1 || strlen($username) === 0) {
            throw new Exception("Usernames is not valid. Only letters and numbers allowed");
        } elseif (!User::checkUnique("username", $username)) {
            throw new Exception("This username is already taken.");
        }

        $this->username = $username;

        return $this;
    }

    public function setEmail (string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email address is not valid.");
        } elseif (!User::checkUnique("email", $email)) {
            throw new Exception("An account with this email address already exists.");
        }
        
        $this->email = $email;

        return $this;
    }

    public function setPassword (string $password)
    {
        if (strlen($password) <= 8) {
            throw new Exception("Your password does not meet the given criteria.");
        }
        
        $hash = password_hash($password, PASSWORD_DEFAULT, [ "cost" => 12 ]);

        $this->password = $hash;

        return $this;
    }

    public function setBiography (string $biography)
    {
        if (strlen($biography) > 150) {
            throw new Exception("The allowed maximum length of a biography is 150 characters");
        }

        $this->biography = $biography;
        return $this;
    }

    public function setProfileImg (string $profileImg)
    {
        $profileImg = "assets/images/user-submit/" . $profileImg;
        $this->profileImg = $profileImg;
        return $this;
    }


    // Check if certain value is unique or already in the database.
    public static function checkUnique($columnName, $value): bool
    {
        $PDO = Database::getInstance();

        //binding column names not possible so manual sql injection protection
        $acceptedColumnNames = ['username', 'email'];

        if (!in_array($columnName, $acceptedColumnNames)) {
            throw new Exception("Name of column must be one of the following:" . implode(", ", $acceptedColumnNames));
        }

        $stmt = $PDO->prepare("select * from users where $columnName = :columnValue");
        $stmt->bindValue(":columnValue", $value);
        $stmt->execute();
        $result = $stmt->fetch();

        return $result === false ? true : false;
    }


    // Basic database methods (insert, update, delete)

    public function insertUser(): void
    {
        $PDO = Database::getInstance();

        $stmt = $PDO->prepare("Insert into users (username, email, password) values (:username, :email, :password)");
        $stmt->bindValue(":username", $this->username);
        $stmt->bindValue(":email", $this->email);
        $stmt->bindValue(":password", $this->password);
        $success = $stmt->execute();

        if (!$success) {
            throw new Exception("Something went wrong. Try again later");
        }
    }

    public function updateUser(): void
    {
        $PDO = Database::getInstance();

        $sql = "UPDATE users 
                SET username =  case 
                                    when :username is not null and length(:username) > 0 then :username
                                    else username
                                end,
                    email =     case
                                    when :email is not null and length(:email) > 0 then :email
                                    else email
                                end,
                    password =  case
                                    when :password is not null and length(:password) > 0 then :password
                                    else password
                                end,
                    biography = case
                                    when :biography is not null and length(:biography) > 0 then :biography
                                    when :biography is not null then null
                                    else biography
                                end,
                    profile_pic = case
                                    when :profileImg is not null and length(:profileImg) > 0 then :profileImg
                                    else profile_pic
                                end
                WHERE id = :id
        ";

        $stmt = $PDO->prepare($sql);
        $stmt->bindValue(":username", $this->username);
        $stmt->bindValue(":email", $this->email);
        $stmt->bindValue(":password", $this->password);
        $stmt->bindValue(":biography", $this->biography);
        $stmt->bindValue(":profileImg", $this->profileImg);
        $stmt->bindValue(":id", $this->id);
        $stmt->execute();

        $count = $stmt->rowCount();

        if ($count == 0) throw new Exception("Something went wrong. Try again later");
    }

    public function deleteUser(): void
    {
        $PDO = Database::getInstance();

        $sql = "DELETE FROM users WHERE id = :id";

        $statement = $PDO->prepare($sql);
        $statement->bindValue(":id", $this->id);
        $statement->execute();

        $count = $statement->rowCount();

        if ($count == 0) throw new Exception("Something went wrong. Try again later");
    }

    public function deactivateUser(): void
    {
        $PDO = Database::getInstance();

        $stmt = $PDO->prepare("UPDATE users SET active = 0 WHERE id = :id");
        $stmt->bindValue(":id", $this->id);
        $stmt->execute();

        $count = $stmt->rowCount();

        if ($count == 0) throw new Exception("Something went wrong. Try again later");
    }


    // static functions

    public static function verifyPassword (string $password, string $email): bool 
    {
        $PDO = Database::getInstance();
        $statement = $PDO->prepare("SELECT * FROM `users` WHERE email = :email");
        $statement->bindValue(":email", $email);
        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if ($user === false) {
            return false;
        }

        return password_verify($password, $user['password']);
    }

    public static function canLogin (string $password, string $email): bool
    {
        
        if (User::verifyPassword($password, $email)) {

            User::checkEmailVerified($email);

            $PDO = Database::getInstance();
            $stmt = $PDO->prepare("UPDATE users SET last_login = NOW(), active = 1 WHERE email = :email");
            $stmt->bindValue(":email", $email);
            $stmt->execute();

            return true;

        } else {
            throw new Exception("Email and/or password are incorrect.");
        }
    }

    // get user methods

    public static function getUserById (int $id): array
    {
        $PDO = Database::getInstance();
        $stmt = $PDO->prepare("SELECT * FROM `users` WHERE id = :id AND active = 1");
        $stmt->bindValue(":id", $id);
        $stmt->execute();

        $result = $stmt->fetch();

        if ($result == false) {
            throw new Exception("User with this email does not exist.");
        }
        
        return $result;
    }

    public static function getUserByEmail (string $email): array
    {
        $PDO = Database::getInstance();
        $stmt = $PDO->prepare("SELECT * FROM `users` WHERE email = :email AND active = 1");
        $stmt->bindValue(":email", $email);
        $stmt->execute();

        $result = $stmt->fetch();
        
        if ($result == false) {
            throw new Exception("User with this email does not exist.");
        }
        
        return $result;
    }


    // misc

    public static function verifyEmail (string $id): void
    {
        $PDO = Database::getInstance();

        // check if there is a user with this code that has already been verified
        $stmt2 = $PDO->prepare("select * from users where email_verified = 1 and id = :id");
        $stmt2->bindValue(":id", $id);
        $stmt2->execute();
        $result = $stmt2->fetch();

        // update email verified if there is a user with this code that has not been verified yet
        $stmt = $PDO->prepare("update users set email_verified = 1 where id = :id and email_verified = 0");
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $count = $stmt->rowCount();

        if ($count == 0 && $result == false) throw new Exception("Something went wrong. Please try again later.");
    }

    public static function checkEmailVerified (string $email)
    {
        $PDO = Database::getInstance();
        $stmt = $PDO->prepare("select email_verified from users where email = :email");
        $stmt->bindValue(":email", $email);
        $stmt->execute();

        $result = $stmt->fetch();

        if ($result['email_verified'] === 0) {
            throw new Exception("This account has not been verified yet. An email with a verification link has been send.");
        }
    }
}