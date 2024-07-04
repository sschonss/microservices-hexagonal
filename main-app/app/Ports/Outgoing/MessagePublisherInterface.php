<?php

namespace App\Ports\Outgoing;

interface MessagePublisherInterface
{
    public function publish(string $message): void;
}
