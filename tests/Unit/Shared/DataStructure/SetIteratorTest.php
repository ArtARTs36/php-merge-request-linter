<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\DataStructure;

use ArtARTs36\MergeRequestLinter\Shared\DataStructure\SetIterator;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class SetIteratorTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\SetIterator::rewind
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\SetIterator::valid
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\SetIterator::current
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\SetIterator::key
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\SetIterator::next
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\SetIterator::__construct
     */
    public function testIterator(): void
    {
        $iterator = new SetIterator([
            'k_1' => 1,
            'k_2' => 2,
            'k_3' => 3,
            'k_4' => 4,
            'k_5' => 5,
        ]);

        $result = [];

        foreach ($iterator as $k => $v) {
            $result[$k] = $v;
        }

        self::assertEquals([1, 2, 3, 4, 5], $result);
    }
}
