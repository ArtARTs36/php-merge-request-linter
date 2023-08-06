<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\DataStructure;

use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ArrayeeTest extends TestCase
{
    public function providerForTestContainsAny(): array
    {
        return [
            [
                [1, 2, 3],
                [1, 2],
                true,
            ],
            [
                [1, 2, 3],
                [1],
                true,
            ],
            [
                [1, 2, 3],
                [4],
                false,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee::containsAny
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee::__construct
     * @dataProvider providerForTestContainsAny
     */
    public function testContainsAny(array $items, array $needle, bool $expected): void
    {
        $arrayee = new Arrayee($items);

        self::assertEquals($expected, $arrayee->containsAny($needle));
    }

    public function providerForTestContains(): array
    {
        return [
            [
                [1, 2, 3],
                3,
                true,
            ],
            [
                [1, 2, 3],
                4,
                false,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee::contains
     * @dataProvider providerForTestContains
     */
    public function testContains(array $items, mixed $needle, bool $expected): void
    {
        $arrayee = new Arrayee($items);

        self::assertEquals($expected, $arrayee->contains($needle));
    }

    public function providerForTestFirst(): array
    {
        return [
            [
                [1, 2, 3],
                1,
            ],
            [
                [1],
                1,
            ],
            [
                [],
                null,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee::first
     * @dataProvider providerForTestFirst
     */
    public function testFirst(array $items, mixed $expected): void
    {
        $arrayee = new Arrayee($items);

        self::assertEquals($expected, $arrayee->first());
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee::implode
     */
    public function testImplode(): void
    {
        $arrayee = new Arrayee([1, 2, 3]);

        self::assertEquals('1 2 3', $arrayee->implode(' '));
    }

    public function providerForTestFirsts(): array
    {
        return [
            [
                [1, 2, 3],
                2,
                [1, 2],
            ],
            [
                [],
                2,
                [],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee::firsts
     * @dataProvider providerForTestFirsts
     */
    public function testFirsts(array $values, int $count, array $expected): void
    {
        $arrayee = new Arrayee($values);

        self::assertEquals($expected, $arrayee->firsts($count)->mapToArray(fn ($item) => $item));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee::mapToArray
     */
    public function testMapToArray(): void
    {
        $arrayee = new Arrayee([1, 2, 3]);

        $result = $arrayee->mapToArray(fn (int $val) => '- ' . $val);

        self::assertEquals([
            '- 1',
            '- 2',
            '- 3',
        ], $result);
    }

    public function providerForTestMerge(): array
    {
        return [
            [
                [1, 2],
                [3, 4],
                [1, 2, 3, 4],
            ],
            [
                [1, 2],
                new Arrayee([3, 4]),
                [1, 2, 3, 4],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee::merge
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee::__construct
     * @dataProvider providerForTestMerge
     */
    public function testMerge(array $arrayee, array|Arrayee $forMerge, array $expected): void
    {
        $arrayee = new Arrayee($arrayee);

        self::assertEquals($expected, $arrayee->merge($forMerge)->mapToArray(fn ($val) => $val));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee::__debugInfo
     */
    public function testDebugInfo(): void
    {
        $arrayee = new Arrayee([1, 2]);

        self::assertEquals([
            'count' => 2,
            'items' => [1, 2],
        ], $arrayee->__debugInfo());
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee::getIterator
     */
    public function testGetIterator(): void
    {
        $arrayee = new Arrayee($items = [1, 2]);

        $iterator = $arrayee->getIterator();

        self::assertInstanceOf(\ArrayIterator::class, $iterator);
        self::assertEquals($items, $iterator->getArrayCopy());
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee::jsonSerialize
     */
    public function testJsonSerialize(): void
    {
        $arrayee = new Arrayee($items = [1, 2]);

        self::assertEquals($items, $arrayee->jsonSerialize());
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee::filter
     */
    public function testFilter(): void
    {
        $arrayee = new Arrayee([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);
        $result = $arrayee->filter(function (int $val) {
            return $val > 5;
        });

        self::assertEquals(
            [6, 7, 8, 9, 10],
            $result->mapToArray(function (int $val) {
                return $val;
            }),
        );
    }

    public function providerForTestFirstFilter(): array
    {
        return [
            [
                [1, 2, 3, 4, 5],
                fn (int $n) => $n > 3,
                4,
            ],
            [
                [1, 2, 3, 4, 5],
                fn (int $n) => $n > 5,
                null,
            ],
            [
                [],
                fn (int $n) => $n > 5,
                null,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee::firstFilter
     *
     * @dataProvider providerForTestFirstFilter
     */
    public function testFirstFilter(array $items, callable $filter, mixed $expected): void
    {
        $arrayee = new Arrayee($items);

        self::assertEquals($expected, $arrayee->firstFilter($filter));
    }

    public function providerForTestSkip(): array
    {
        return [
            [
                [],
                5,
                [],
            ],
            [
                [1, 2, 3, 4, 5],
                2,
                [3, 4, 5],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee::skip
     *
     * @dataProvider providerForTestSkip
     */
    public function testSkip(array $items, int $offset, array $expected): void
    {
        $arrayee = new Arrayee($items);

        self::assertEquals($expected, $arrayee->skip($offset)->mapToArray(fn (mixed $item): mixed => $item));
    }
}
