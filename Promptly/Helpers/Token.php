<?php

namespace Promptly\Helpers;

use \PDO;
use \Exception;

require_once(__DIR__ . '/../../vendor/autoload.php');

class Token
{
    private $token;
    private $type;
    private $userId;

    // getters

    public function getToken(): string
    {
        return $this->token;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    // setters

    public function generateToken(string $modifier = "")
    {
        $randomHex = bin2hex(random_bytes(100));
        $token = md5($randomHex . time() . $modifier);

        $this->token = $token;
        return $this;
    }

    public function setType(string $type)
    {
        if ($type != "password" && $type != "email") {
            throw new Exception("Token must be of type password or email.");
        }

        $this->type = $type;
        return $this;
    }

    public function setUserId(int $id)
    {
        $this->userId = $id;
        return $this;
    }

    // insert token

    public function insertToken(): void
    {
        $PDO = Database::getInstance();

        $hashedToken = md5($this->token);

        $stmt = $PDO->prepare("insert into temp_tokens (user_id, token, type) values (:user_id, :token, :type)");
        $stmt->bindValue(":user_id", $this->userId);
        $stmt->bindValue(":token", $hashedToken);
        $stmt->bindValue(":type", $this->type);
        $success = $stmt->execute();

        if (!$success) {
            throw new Exception("Something went wrong with creating an email verification token. Please contact support");
        }
    }

    // get token object

    public static function getTokenObject(string $token, string $type): array
    {
        $PDO = Database::getInstance();

        $hashedToken = md5($token);

        $stmt = $PDO->prepare("select * from temp_tokens where token = :token and type = :type and time_created >= now() - interval 1 day");
        $stmt->bindValue(":token", $hashedToken);
        $stmt->bindValue(":type", $type);
        $stmt->execute();
        $result = $stmt->fetch();

        if ($result == false) {
            throw new Exception("This token does not exist or is no longer valid. If needed request a new token.");
        }

        return $result;
    }

    // delete token

    public static function deleteToken(int $id): void
    {
        $PDO = Database::getInstance();

        $stmt = $PDO->prepare("delete from temp_tokens where id = :id");
        $stmt->bindValue(":id", $id);
        $stmt->execute();
    }
}
