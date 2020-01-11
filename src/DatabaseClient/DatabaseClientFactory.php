<?php declare(strict_types=1);

namespace Comquer\Persistence\DatabaseClient;

interface DatabaseClientFactory
{
    public static function create(
        string $host,
        int $port,
        string $username,
        string $password,
        string $databaseName
    ) : DatabaseClient;
}