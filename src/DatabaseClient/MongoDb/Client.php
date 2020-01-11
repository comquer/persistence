<?php declare(strict_types=1);

namespace Comquer\Persistence\DatabaseClient\MongoDb;

use Comquer\Persistence\DatabaseClient\DatabaseClient;
use MongoDB\Client as NativeClient;
use MongoDB\Driver\Command;

class Client implements DatabaseClient
{
    private string $databaseName;

    private NativeClient $nativeClient;

    public function __construct(string $databaseName, NativeClient $nativeClient)
    {
        $this->databaseName = $databaseName;
        $this->nativeClient = $nativeClient;
    }

    public function persist(string $collectionName, array $document) : void
    {
        $this->nativeClient
            ->selectCollection($this->databaseName, $collectionName)
            ->insertOne($document);
    }

    public function getByQuery(string $collectionName, array $query) : array
    {
        return $this->nativeClient
            ->selectCollection($this->databaseName, $collectionName)
            ->find($query)
            ->toArray();
    }

    public function upsert(string $collectionName, array $query, array $document) : void
    {
        $upsert = new Command([
            'update' => $collectionName,
            'updates' => [
                [
                    'q' => $query,
                    'u' => $document,
                    'upsert' => true,
                    'multi' => false
                ]
            ]
        ]);

        $this->nativeClient->getManager()->executeCommand($this->databaseName, $upsert);
    }

    public function dropDatabase(): void
    {
        $this->nativeClient->dropDatabase($this->databaseName);
    }
}