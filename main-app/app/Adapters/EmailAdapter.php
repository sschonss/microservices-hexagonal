<?php

namespace App\Adapters;

use App\Core\Connections\RabbitMQ;

class EmailAdapter
{
    public function sendEmail($email): array
    {
        $rabbitMQ = new RabbitMQ('queue-email');
        $rabbitMQ->publish( json_encode($email));

        return ['message' => 'Email sent successfully'];
    }
}
