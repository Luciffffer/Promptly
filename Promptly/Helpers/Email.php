<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use Postmark\PostmarkClient;

class Email
{
    private $server = "c1b58c69-6caf-4e5c-8d19-538c5eb8aeda";
    private $fromEmail = "no-reply@lucifarian.be";
    private $toEmail;
    private $username;
    private $token;

    // getters

    public function getToEmail(): string
    {
        return $this->toEmail;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    // setters

    public function setToEmail(string $email)
    {
        $this->toEmail = $email;
        return $this;
    }

    public function setUsername(string $username = "User")
    {
        $this->username = $username;
        return $this;
    }

    public function setToken(string $token)
    {
        $this->token = $token;
        return $this;
    }

    // emails

    public function sendVerificationEmail(): void
    {
        $client = new PostmarkClient($this->server);

        $sendResult = $client->sendEmailWithTemplate(
            $this->fromEmail,
            $this->toEmail,
            31306538, // Message template
            [
            "product_url" => "http://localhost/php/promptly",
            "product_name" => "Promptly",
            "name" => $this->username,
            "action_url" => "http://localhost/php/promptly/tools/verify-email?code=" . $this->token,
            "support_url" => "http://localhost/php/promptly/support",
            "company_name" => "Promptly",
            "company_address" => "",
            ],
            true, // Inline css
            null, // Tag
            null, // Track opens
            null, // Reply To
            null, // CC
            null, // BCC
            null, // Header array
            null, // Attachment array
            null, // Track links
            null, // Metadata array
            "email-verification" // Message stream
        );
    }

    public function sendPasswordReset(): void
    {
        $client = new PostmarkClient($this->server);

        $sendResult = $client->sendEmailWithTemplate(
            $this->fromEmail,
            $this->toEmail,
            31316940, // Message template
            [
            "product_url" => "http://localhost/php/promptly",
            "product_name" => "Promptly",
            "name" => $this->username,
            "action_url" => "http://localhost/php/promptly/tools/reset-password?token=" . $this->token,
            "support_url" => "http://localhost/php/promptly/support",
            "company_name" => "Promptly",
            "company_address" => "",
            ],
            true, // Inline css
            null, // Tag
            null, // Track opens
            null, // Reply To
            null, // CC
            null, // BCC
            null, // Header array
            null, // Attachment array
            null, // Track links
            null, // Metadata array
            "password_reset" // Message stream
        );
    }
}
