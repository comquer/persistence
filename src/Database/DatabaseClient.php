<?php declare(strict_types=1);

namespace Comquer\Persistence\Database;

interface DatabaseClient
{
    public function persist(string $collectionName, array $document) : void;

    public function getByQuery(string $collectionName, array $query) : array;

    public function upsert(string $collectionName, array $query, array $document) : void;
}