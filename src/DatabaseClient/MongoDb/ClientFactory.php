<?php declare(strict_types=1);

namespace Comquer\Persistence\DatabaseClients\MongoDb;

use Comquer\Persistence\DatabaseClient\MongoDb\Client;
use Comquer\Persistence\DatabaseClientFactory;
use MongoDB\Client as NativeClient;

class ClientFactory implements DatabaseClientFactory
{
    public static function create(string $host, int $port, string $username, string $password, string $databaseName) : Client
    {
        return new Client(
            $databaseName,
            new NativeClient("mongodb://$username:$password@$host:$port")
        );
    }
}