<?php declare(strict_types=1);

namespace Comquer\Persistence\Queue;

interface QueuePublisher
{
    public function __invoke(string $queueName, array $message) : void;
}
