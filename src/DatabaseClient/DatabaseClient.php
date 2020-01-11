<?php declare(strict_types=1);

namespace Comquer\Persistence;

interface DatabaseClient
{
    public function upsert(string $collectionName, array $query, array $document) : void;

//    public function getByQuery(string $collectionName, array $query) : array;
}