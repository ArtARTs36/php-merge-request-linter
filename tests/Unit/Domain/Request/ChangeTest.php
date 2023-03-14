<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Domain\Request;

use ArtARTs36\MergeRequestLinter\Domain\Request\Change;
use ArtARTs36\MergeRequestLinter\Domain\Request\Diff;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ChangeTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Domain\Request\Change::__toString
     * @covers \ArtARTs36\MergeRequestLinter\Domain\Request\Change::__construct
     */
    public function testToString(): void
    {
        $change = new Change('file.txt', new Diff([]));

        self::assertEquals('file.txt', $change->__toString());
    }
}
