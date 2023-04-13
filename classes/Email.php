<?php

require_once(__DIR__ . '/../vendor/autoload.php');
use Postmark\PostmarkClient;

class Email
{
    private $server = "c1b58c69-6caf-4e5c-8d19-538c5eb8aeda";
    private $fromEmail = "no-reply@lucifarian.be";

    public function sendVerificationEmail (string $email, string $code, string $username): void
    {
        $client = new PostmarkClient($this->server);
        
        $sendResult = $client->sendEmailWithTemplate(
            $this->fromEmail,
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

    public function sendPasswordReset (string $email, string $token, string $username): void
    {
        $client = new PostmarkClient($this->server);

        $sendResult = $client->sendEmailWithTemplate(
            $this->fromEmail,
            $email,
            31316940, // Message template
            [
            "product_url" => "http://localhost/php/promptly",
            "product_name" => "Promptly",
            "name" => $username,
            "action_url" => "http://localhost/php/promptly/tools/reset_password?token=" . $token,
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
            "password_reset" // Message stream
        );
    }
}