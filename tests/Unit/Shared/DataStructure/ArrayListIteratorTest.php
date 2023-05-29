<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\DataStructure;

use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayListIterator;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ArrayListIteratorTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayListIterator::rewind
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayListIterator::valid
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayListIterator::current
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayListIterator::key
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayListIterator::next
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayListIterator::__construct
     */
    public function testIterator(): void
    {
        $iterator = new ArrayListIterator([
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
