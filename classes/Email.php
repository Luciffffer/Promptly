<?php

require_once(__DIR__ . "/Database.php");
require_once(__DIR__ . '/../vendor/autoload.php');
use Postmark\PostmarkClient;

class Email
{
    public static function generateVerificationCode (): string // Can create unique id's for 3050 people currently. Feel free to improve
    {
        $permittedChars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $PDO = Database::getInstance();
        $unique = false;

        while ($unique === false) {
            $string = substr(str_shuffle($permittedChars), 0, 50);

            $stmt = $PDO->prepare("select * from users where email_verification_code = :code");
            $stmt->bindValue(":code", $string);
            $stmt->execute();

            if ($stmt->fetch() == false) {
                $unique = true;
                return $string;
            }
        }
    }

    public static function sendVerificationEmail (string $email, string $code, string $username): void 
    {
        $client = new PostmarkClient("c1b58c69-6caf-4e5c-8d19-538c5eb8aeda");
        
        $sendResult = $client->sendEmailWithTemplate(
            "contact@lucifarian.be",
            $email,
            31306538, // Message template
            [
            "product_url" => "http://localhost/php/promptly",
            "product_name" => "Promptly",
            "name" => $username,
            "action_url" => "http://localhost/php/promptly/tools/verify-email?code=" . $code,
            "support_url" => "http://localhost/php/promptly/support",
            "company_name" => "Promptly",
            "company_address" => "",
            ],
            true, // Inline css
            NULL, // Tag
            NULL, // Track opens
            NULL, // Reply To
            NULL, // CC
            NULL, // BCC
            NULL, // Header array
            NULL, // Attachment array
            NULL, // Track links
            NULL, // Metadata array
            "email-verification" // Message stream
        );
    }
}