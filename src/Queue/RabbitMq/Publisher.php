<?php declare(strict_types=1);

namespace Comquer\Persistence\Queue\RabbitMq;

use Comquer\Persistence\Queue\QueuePublisher;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Publisher implements QueuePublisher
{
    private AMQPStreamConnection $connection;

    public function __construct(AMQPStreamConnection $connection)
    {
        $this->connection = $connection;
    }

    public function __invoke(string $queueName, array $message): void
    {
        $channel = $this->connection->channel();
        $channel->queue_declare($queueName, false, false, false, false);

        $channel->basic_publish(
            new AMQPMessage(json_encode($message)),
            '',
            $queueName
        );

        $channel->close();
    }
}