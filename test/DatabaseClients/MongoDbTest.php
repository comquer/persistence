<?php declare(strict_types=1);

namespace Comquer\PersistenceTest\DatabaseClients;

use PHPUnit\Framework\TestCase;

class MongoDbTest extends TestCase
{
    /** @test */
    function upsert_saves_document_non_existent()
    {
        $document = [
            'some' => 'data',
            'some more' => 'irrelevant data',
            'number' => 7,
        ];


    }
}