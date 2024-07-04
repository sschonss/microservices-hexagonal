<?php

namespace App\Core\Email;

use App\Adapters\EmailAdapter;

class EmailService
{
    protected EmailAdapter $emailAdapter;

    public function __construct()
    {
        $this->emailAdapter = new EmailAdapter();
    }

    public function send($email): array
    {
        return $this->emailAdapter->sendEmail($email);
    }
}
