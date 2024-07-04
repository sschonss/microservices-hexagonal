<?php

namespace App\Core\Email;

class WelcomeEmail
{
    protected EmailService $emailService;

    public function __construct()
    {
        $this->emailService = new EmailService();
    }

    public function sendEmail($email): array
    {
        return $this->emailService->send($email);
    }

}
