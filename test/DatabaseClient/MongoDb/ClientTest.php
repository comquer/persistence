<?php declare(strict_types=1);

namespace Comquer\PersistenceTest\DatabaseClient\MongoDb;

use Comquer\Persistence\DatabaseClient\MongoDb\ClientFactory;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    /** @test */
    function persist_and_get_multiple_documents()
    {
        $document = [
            'some' => 'data',
            'some more' => 'irrelevant data',
            'number' => 7,
        ];

        $client = ClientFactory::create(
            'localhost',
            27017,
            'user',
            'password',
            'test_mongo_db'
        );

        $client->persist('test collection', $document);
        $client->persist('test collection', $document);

        $documents = $client->getByQuery('test collection', []);

        self::assertCount(2, $documents);
    }
}