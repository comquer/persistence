<?php declare(strict_types=1);

namespace Comquer\Persistence\Database\MongoDb;

use Comquer\Persistence\Database\DatabaseClientFactory;
use MongoDB\Client as NativeClient;

class ClientFactory implements DatabaseClientFactory
{
    public static function create(
        string $host,
        int $port,
        string $databaseName,
        string $username = null,
        string $password = null
    ) : Client {
        return new Client(
            $databaseName,
            new NativeClient("mongodb://$host:$port")
        );
    }
}