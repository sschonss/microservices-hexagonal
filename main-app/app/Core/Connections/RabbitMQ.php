<?php

namespace App\Core\Connections;

use App\Adapters\RabbitMQAdapter;

class RabbitMQ
{
    protected RabbitMQAdapter $rabbitMQAdapter;

    public function __construct(string $queue)
    {
        $this->rabbitMQAdapter = new RabbitMQAdapter('queue-email');
    }

    public function publish(string $message): void
    {
        $this->rabbitMQAdapter->publish($message);
    }
}
