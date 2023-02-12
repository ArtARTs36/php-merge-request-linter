<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Support;

use ArtARTs36\MergeRequestLinter\Shared\Iterators\ArrayKeyIterator;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ArrayKeyIteratorTest extends TestCase
{
    public function providerForTestIterate(): array
    {
        return [
            [
                [
                    'val1' => true,
                    'val2' => true,
                ],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Iterators\ArrayKeyIterator
     * @dataProvider providerForTestIterate
     */
    public function testIterate(array $map): void
    {
        $iterator = new ArrayKeyIterator($map);

        foreach ($iterator as $value) {
            unset($map[$value]);
        }

        self::assertCount(0, $map);
    }
}
