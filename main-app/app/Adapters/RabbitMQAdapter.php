<?php

namespace App\Adapters;

use Exception;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQAdapter
{
    protected AMQPStreamConnection $connection;
    protected AMQPChannel $channel;
    protected string $queue;

    /**
     * @throws Exception
     */
    public function __construct(string $queue)
    {
        $this->setupRabbitMQ($queue);
    }

    /**
     * @throws Exception
     */
    private function setupRabbitMQ(string $queue): void
    {
        $this->queue = $queue;
        $this->connection = new AMQPStreamConnection(
            env('RABBITMQ_HOST', '127.0.0.1'),
            env('RABBITMQ_PORT', 5672),
            env('RABBITMQ_USER', 'guest'),
            env('RABBITMQ_PASSWORD', 'guest')
        );

        $this->channel = $this->connection->channel();
        $this->channel->queue_declare($this->queue, false, true, false, false);

    }

    public function publish(string $message): void
    {
        $amqpMessage = new AMQPMessage($message, ['delivery_mode' => 2]);
        $this->channel->basic_publish($amqpMessage, '', $this->queue);
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }

}
