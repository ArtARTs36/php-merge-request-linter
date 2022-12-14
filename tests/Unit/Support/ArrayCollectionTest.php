<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Support;

use ArtARTs36\MergeRequestLinter\Support\DataStructure\ArrayCollection;
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
     * @covers \ArtARTs36\MergeRequestLinter\Support\DataStructure\ArrayCollection::count
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
     * @covers \ArtARTs36\MergeRequestLinter\Support\DataStructure\ArrayCollection::isEmpty
     */
    public function testIsEmpty(array $items, bool $expected): void
    {
        self::assertEquals($expected, (new ArrayCollection($items))->isEmpty());
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Support\DataStructure\ArrayCollection::getIterator
     */
    public function testGetIterator(): void
    {
        self::assertEquals([1, 2], iterator_to_array(new ArrayCollection([1, 2])));
    }

    public function providerForTestFirst(): array
    {
        return [
            [
                [],
                null,
            ],
            [
                [1, 2],
                1,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestFirst
     * @covers \ArtARTs36\MergeRequestLinter\Support\DataStructure\ArrayCollection::first
     * @covers \ArtARTs36\MergeRequestLinter\Support\DataStructure\ArrayCollection::__construct
     */
    public function testFirst(array $items, mixed $expected): void
    {
        self::assertEquals($expected, (new ArrayCollection($items))->first());
    }

    public function providerForTestEqualsCount(): array
    {
        return [
            [
                [1, 2],
                [3, 4],
                true,
            ],
            [
                [1],
                [],
                false,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestEqualsCount
     * @covers \ArtARTs36\MergeRequestLinter\Support\DataStructure\ArrayCollection::equalsCount
     */
    public function testEqualsCount(array $one, array $two, bool $expected): void
    {
        self::assertEquals($expected, (new ArrayCollection($one))->equalsCount(new ArrayCollection($two)));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Support\DataStructure\ArrayCollection::implode
     */
    public function testImplode(): void
    {
        self::assertEquals('1,2', (new ArrayCollection([1, 2]))->implode(','));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Support\DataStructure\ArrayCollection::diff
     */
    public function testDiff(): void
    {
        self::assertEquals(
            [1, 2],
            iterator_to_array((new ArrayCollection([1, 2, 3, 4]))->diff(new ArrayCollection([3, 4])))
        );
    }
}
