<?php declare(strict_types=1);

namespace Comquer\PersistenceTest\Queue\RabbitMq;

use Comquer\Persistence\Queue\RabbitMq\ConnectionFactory;
use Comquer\Persistence\Queue\RabbitMq\Consumer;
use Comquer\Persistence\Queue\RabbitMq\Publisher;
use PHPUnit\Framework\TestCase;

class PublisherAndConsumerTest extends TestCase
{
    private const QUEUE = 'test queue';

    private Publisher $publisher;

    private Consumer $consumer;

    function setUp() : void
    {
        $connection = ConnectionFactory::create(
            'localhost',
            5672,
            'guest',
            'guest'
        );

        $this->publisher = new Publisher($connection);
        $this->consumer = new Consumer($connection);
        parent::setUp();
    }

    /** @test */
    function publish_and_consume_messages()
    {
        $this->markTestSkipped();

        $message = [
            'message' => 'unconsumed',
        ];

        ($this->publisher)(self::QUEUE, $message);

        ($this->consumer)(self::QUEUE, function (array $message) {
            $message['message'] = 'consumed';
        });

        self::assertSame('consumed', $message['message']);
    }
}