<?php declare(strict_types=1);

namespace Comquer\Persistence\Queue;

interface QueueConsumer
{
    public function __invoke(string $queueName, callable $callback) : void;
}