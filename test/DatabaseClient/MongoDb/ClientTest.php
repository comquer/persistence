<?php declare(strict_types=1);

namespace Comquer\PersistenceTest\DatabaseClient\MongoDb;

use Comquer\Persistence\DatabaseClient\MongoDb\Client;
use Comquer\Persistence\DatabaseClient\MongoDb\ClientFactory;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    private Client $client;

    public function setUp() : void
    {
        $this->client = ClientFactory::create(
            'localhost',
            27017,
            'test_mongo_db',
            'user',
            'password',
        );

        parent::setUp();
    }

    /** @test */
    function persist_and_get_multiple_documents()
    {
        $document = [
            'some' => 'data',
            'some more' => 'irrelevant data',
            'number' => 7,
        ];

        $this->client->persist('test collection', $document);
        $this->client->persist('test collection', $document);

        $documents = $this->client->getByQuery('test collection', []);

        self::assertCount(2, $documents);
    }
}