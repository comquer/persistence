<?php declare(strict_types=1);

namespace Comquer\Persistence\Queue\RabbitMq;

use Comquer\Persistence\Queue\QueueConsumer;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Consumer implements QueueConsumer
{
    private AMQPStreamConnection $connection;

    public function __construct(AMQPStreamConnection $connection)
    {
        $this->connection = $connection;
    }

    public function __invoke(string $queueName, callable $callback): void
    {
        $channel = $this->connection->channel();
        $channel->queue_declare($queueName, false, false, false, false);

        $channel->basic_consume(
            $queueName,
            '',
            false,
            true,
            false,
            false,
            function (AMQPMessage $message) use ($callback) {
                $callback(json_decode($message->getBody(), true));
            }
        );

        while (count($channel->callbacks)) {
            $channel->wait();
        }

        $channel->close();
    }
}