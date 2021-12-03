<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Support;

use ArtARTs36\MergeRequestLinter\Support\ArrayCollection;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ArrayCollectionTest extends TestCase
{
    public function providerForTestCount(): array
    {
        return [
            [
                [],
                0,
            ],
            [
                [
                    1,
                    2,
                ],
                2,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestCount
     * @covers \ArtARTs36\MergeRequestLinter\Support\ArrayCollection::count
     */
    public function testCount(array $items, int $expectedCount): void
    {
        self::assertEquals($expectedCount, (new ArrayCollection($items))->count());
    }

    public function providerForTestIsEmpty(): array
    {
        return [
            [
                [],
                true,
            ],
            [
                [1, 2],
                false,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestIsEmpty
     * @covers \ArtARTs36\MergeRequestLinter\Support\ArrayCollection::isEmpty
     */
    public function testIsEmpty(array $items, bool $expected): void
    {
        self::assertEquals($expected, (new ArrayCollection($items))->isEmpty());
    }
}
