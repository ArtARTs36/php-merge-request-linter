<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\DataStructure;

use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ArrayMapTest extends TestCase
{
    public function providerForTestGet(): array
    {
        return [
            [
                [
                    'k1' => 'v1',
                    'k2' => 'v2',
                ],
                'k1',
                'v1',
            ],
            [
                [
                    'k1' => 'v1',
                    'k2' => 'v2',
                ],
                'k3',
                null,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestGet
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap::get
     */
    public function testGet(array $items, string $id, mixed $value): void
    {
        self::assertEquals($value, (new ArrayMap($items))->get($id));
    }

    public function providerForTestHas(): array
    {
        return [
            [
                [
                    'k1' => 'v1',
                    'k2' => 'v2',
                ],
                'k1',
                true,
            ],
            [
                [
                    'k1' => 'v1',
                    'k2' => 'v2',
                ],
                'k3',
                false,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestHas
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap::has
     */
    public function testHas(array $items, string $id, bool $expected): void
    {
        self::assertEquals($expected, (new ArrayMap($items))->has($id));
    }

    public function providerForTestMissing(): array
    {
        return [
            [
                [
                    'k1' => 'v1',
                    'k2' => 'v2',
                ],
                'k1',
                false,
            ],
            [
                [
                    'k1' => 'v1',
                    'k2' => 'v2',
                ],
                'k3',
                true,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestMissing
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap::missing
     */
    public function testMissing(array $items, string $id, bool $expected): void
    {
        self::assertEquals($expected, (new ArrayMap($items))->missing($id));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap::diff
     */
    public function testDiff(): void
    {
        self::assertEquals(
            ['one' => 1],
            iterator_to_array((new ArrayMap(['one' => 1, 't' => 2]))->diff(new ArrayMap(['t' => 2])))
        );
    }

    public function providerForTestFirst(): array
    {
        return [
            [
                new ArrayMap([
                    'one' => 1,
                ]),
                1,
            ],
            [
                new ArrayMap([
                    'one' => 1,
                    'two' => 2,
                ]),
                1,
            ],
            [
                new ArrayMap([]),
                null,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap::first
     * @dataProvider providerForTestFirst
     */
    public function testFirst(ArrayMap $map, mixed $expected): void
    {
        self::assertEquals($expected, $map->first());
    }

    public function providerForTestSearch(): array
    {
        return [
            [
                [
                    'key1' => 1,
                    'key2' => 2,
                ],
                1,
                'key1',
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap::search
     * @dataProvider providerForTestSearch
     */
    public function testSearch(array $map, mixed $value, mixed $expectedKey): void
    {
        $map = new ArrayMap($map);

        self::assertEquals($expectedKey, $map->search($value));
    }

    public function providerForTestContains(): array
    {
        return [
            [
                [
                    'key1' => 1,
                    'key2' => 2,
                ],
                1,
                true,
            ],
            [
                [
                    'key1' => 1,
                    'key2' => 2,
                ],
                3,
                false,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap::contains
     * @dataProvider providerForTestContains
     */
    public function testContains(array $map, mixed $value, bool $expected): void
    {
        $map = new ArrayMap($map);

        self::assertEquals($expected, $map->contains($value));
    }
}
