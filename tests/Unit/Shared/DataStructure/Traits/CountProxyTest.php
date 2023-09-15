<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\DataStructure\Traits;

use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Traits\CountProxy;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class CountProxyTest extends TestCase
{
    public function testCount(): void
    {
        $collection = new MockCollection([1, 2]);

        self::assertEquals(2, $collection->count());
    }

    public static function providerForTestIsEmpty(): array
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
     */
    public function testIsEmpty(array $items, bool $expected): void
    {
        $collection = new MockCollection($items);

        self::assertEquals($expected, $collection->isEmpty());
    }

    public static function providerForTestEqualsCount(): array
    {
        return [
            [
                [],
                [],
                true,
            ],
            [
                [1, 2],
                [1, 2],
                true,
            ],
            [
                [1, 2],
                [1],
                false,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestEqualsCount
     */
    public function testEqualsCount(array $itemsOne, array $itemsTwo, bool $expected): void
    {
        $collectionOne = new MockCollection($itemsOne);
        $collectionTwo = new MockCollection($itemsTwo);

        self::assertEquals(
            $expected,
            $collectionOne->equalsCount($collectionTwo),
        );
    }

    public static function providerForTestOnce(): array
    {
        return [
            [
                [],
                false,
            ],
            [
                [1],
                true,
            ],
            [
                [1, 2],
                false,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestOnce
     */
    public function testOnce(array $items, bool $expected): void
    {
        $collection = new MockCollection($items);

        self::assertEquals($expected, $collection->once());
    }
}

class MockCollection implements \Countable
{
    use CountProxy;

    public function __construct(
        private readonly array $items,
    ) {
    }
}
