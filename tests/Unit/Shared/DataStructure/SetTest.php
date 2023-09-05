<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\DataStructure;

use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class SetTest extends TestCase
{
    public function providerTestImplode(): array
    {
        return [
            [
                ['Hello', 'mr.', 'Artem!'],
                ' ',
                'Hello mr. Artem!',
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set::implode
     * @dataProvider providerTestImplode
     */
    public function testImplode(array $set, string $separator, string $expected): void
    {
        $ds = Set::fromList($set);

        self::assertEquals($expected, $ds->implode($separator));
    }

    public function providerForTestFirst(): array
    {
        return [
            [
                [1, 2],
                1,
            ],
            [
                [],
                null,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set::first
     * @dataProvider providerForTestFirst
     */
    public function testFirst(array $set, mixed $expected): void
    {
        self::assertEquals($expected, Set::fromList($set)->first());
    }

    public function providerForTestContains(): array
    {
        return [
            [
                [1, 2, 3],
                1,
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
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set::contains
     * @dataProvider providerForTestContains
     */
    public function testContains(array $set, mixed $value, bool $expected): void
    {
        $set = Set::fromList($set);

        self::assertEquals($expected, $set->contains($value));
    }

    public function providerForTestContainsAll(): array
    {
        return [
            [
                [1, 2, 3],
                [1, 2],
                true,
            ],
            [
                [1, 2, 3],
                [1, 4],
                false,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set::containsAll
     * @dataProvider providerForTestContainsAll
     */
    public function testContainsAll(array $items, array $values, bool $expected): void
    {
        $set = Set::fromList($items);

        self::assertEquals($expected, $set->containsAll($values));
    }

    public function providerForTestFromList(): array
    {
        return [
            [
                [1, 2],
                [1, 2],
            ],
            [
                [1, 2, 2],
                [1, 2],
            ],

            [
                [1.2, 1.3],
                [1.2, 1.3],
            ],
            [
                [1.2, 1.3, 1.3],
                [1.2, 1.3],
            ],

            [
                [false, true],
                [false, true],
            ],
            [
                [false, true, true],
                [false, true],
            ],

            [
                [[1, 2], [1, 3]],
                [[1, 2], [1, 3]],
            ],
            [
                [[1, 2], [1, 3], [1, 3]],
                [[1, 2], [1, 3]],
            ],

            [
                ['test1', 'test2'],
                ['test1', 'test2'],
            ],
            [
                ['test1', 'test2', 'test2'],
                ['test1', 'test2'],
            ],

            [
                [
                    (object)['k' => 'v'],
                    (object)['k' => 'v1'],
                ],
                [
                    (object)['k' => 'v'],
                    (object)['k' => 'v1'],
                ],
            ],

            [
                [
                    (object)['k' => 'v'],
                    $o = (object)['k' => 'v1'],
                    $o,
                ],
                [
                    (object)['k' => 'v'],
                    (object)['k' => 'v1'],
                ],
            ],

            [
                $ss = [
                    fopen('data://text/plain,str1', 'r'),
                    fopen('data://text/plain,str2', 'r'),
                ],
                $ss,
            ],

            [
                [
                    $s1 = fopen('data://text/plain,str1', 'r'),
                    $s2 = fopen('data://text/plain,str2', 'r'),
                    $s2,
                ],
                [
                    $s1,
                    $s2,
                ],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set::fromList
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set::__construct
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set::hash
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set::values
     * @dataProvider providerForTestFromList
     */
    public function testFromList(array $items, array $expected): void
    {
        self::assertEquals($expected, Set::fromList($items)->values());
    }

    public function providerForTestJsonSerialize(): array
    {
        return [
            [
                [1, 2],
                [1, 2],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set::jsonSerialize
     * @dataProvider providerForTestJsonSerialize
     */
    public function testJsonSerialize(array $items, array $expected): void
    {
        self::assertEquals($expected, Set::fromList($items)->jsonSerialize());
    }

    public function providerForTestDiff(): array
    {
        return [
            [
                [1, 2, 3, 4],
                [3, 4],
                [1, 2],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set::diff
     * @dataProvider providerForTestDiff
     */
    public function testDiff(array $items, array $thatItems, array $expectedItems): void
    {
        self::assertEquals(
            $expectedItems,
            Set::fromList($items)->diff(Set::fromList($thatItems))->values(),
        );
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set::getIterator
     */
    public function testGetIterator(): void
    {
        $set = Set::fromList([1, 3, 2, 3, 4, 4, 5]);

        $result = [];

        foreach ($set as $k => $v) {
            $result[$k] = $v;
        }

        self::assertEquals([1, 3, 2, 4, 5], $result);
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set::__debugInfo
     */
    public function testDebugInfo(): void
    {
        $set = Set::fromList([1, 2]);

        self::assertEquals(
            [
                'count' => 2,
                'items' => [1, 2],
            ],
            $set->__debugInfo(),
        );
    }

    public static function providerForTestMerge(): array
    {
        return [
            [
                'source' => [1, 2, 3],
                'merging' => [2, 4],
                'expected' => [1, 2, 3, 4],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set::merge
     *
     * @dataProvider providerForTestMerge
     */
    public function testMerge(array $source, array $merging, array $expected): void
    {
        self::assertEquals(
            Set::fromList($expected),
            Set::fromList($source)->merge($merging),
        );
    }
}
