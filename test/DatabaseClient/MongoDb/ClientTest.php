<?php declare(strict_types=1);

namespace Comquer\PersistenceTest\DatabaseClient\MongoDb;

use Comquer\Persistence\DatabaseClient\MongoDb\Client;
use Comquer\Persistence\DatabaseClient\MongoDb\ClientFactory;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    private const COLLECTION = 'test collection';

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

        $this->client->dropDatabase();

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

        $this->client->persist(self::COLLECTION, $document);
        $this->client->persist(self::COLLECTION, $document);

        $documents = $this->client->getByQuery(self::COLLECTION, []);

        self::assertCount(2, $documents);
    }

    /** @test */
    function persist_two_documents_and_query_one()
    {
        $document = [
            'some' => 'data',
            'number' => 7,
        ];

        $anotherDocument = [
            'number' => 8,
        ];

        $this->client->persist(self::COLLECTION, $document);
        $this->client->persist(self::COLLECTION, $anotherDocument);

        $documents = $this->client->getByQuery(self::COLLECTION, [
            'number' => 8
        ]);

        self::assertCount(1, $documents);
    }

    /** @test */
    function persist_and_upsert_and_query_document()
    {
        $document = [
            'some' => 'data',
            'number' => 7,
        ];

        $anotherDocument = [
            'number' => 8,
        ];

        $this->client->persist(self::COLLECTION, $document);
        $this->client->persist(self::COLLECTION, $anotherDocument);

        $this->client->upsert(
            self::COLLECTION,
            [
                'number' => 8,
            ],
            [
                'number' => 8,
                'some more' => 'random data',
            ]
        );

        $documents = $this->client->getByQuery(self::COLLECTION, [
            'number' => 8,
            'some more' => 'random data',
        ]);

        self::assertCount(1, $documents);
    }
}