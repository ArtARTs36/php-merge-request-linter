<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Container;

use ArtARTs36\MergeRequestLinter\Infrastructure\Container\EntryNotFoundException;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class EntryNotFoundExceptionTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Container\EntryNotFoundException::create
     */
    public function testCreate(): void
    {
        $e = EntryNotFoundException::create('test-id');

        self::assertEquals('Object of class "test-id" not found', $e->getMessage());
    }
}
