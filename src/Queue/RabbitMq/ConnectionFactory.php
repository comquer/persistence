<?php declare(strict_types=1);

namespace Comquer\Persistence\Queue\RabbitMq;

use PhpAmqpLib\Connection\AMQPStreamConnection;

class ConnectionFactory
{
    public static function create(string $host, int $port, string $user, string $password) : AMQPStreamConnection
    {
        return new AMQPStreamConnection($host, $port, $user, $password);
    }
}