<?php declare(strict_types=1);

namespace Comquer\Persistence\DatabaseClient\MongoDb;

use Comquer\Persistence\DatabaseClient;
use MongoDB\Collection;
use MongoDB\Driver\Command;
use MongoDB\Client as NativeClient;

class Client implements DatabaseClient
{
    private string $databaseName;

    private NativeClient $nativeClient;

    public function __construct(string $databaseName, NativeClient $nativeClient)
    {
        $this->databaseName = $databaseName;
        $this->nativeClient = $nativeClient;
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

    private function selectCollection(string $collectionName) : Collection
    {
        return $this->nativeClient->selectCollection($this->databaseName, $collectionName);
    }
}