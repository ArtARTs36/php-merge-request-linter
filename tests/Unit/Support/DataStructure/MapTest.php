<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Support\DataStructure;

use ArtARTs36\MergeRequestLinter\Support\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class MapTest extends TestCase
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
     * @covers \ArtARTs36\MergeRequestLinter\Support\DataStructure\Map::get
     */
    public function testGet(array $items, string $id, mixed $value): void
    {
        self::assertEquals($value, (new Map($items))->get($id));
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
     * @covers \ArtARTs36\MergeRequestLinter\Support\DataStructure\Map::has
     */
    public function testHas(array $items, string $id, bool $expected): void
    {
        self::assertEquals($expected, (new Map($items))->has($id));
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
     * @covers \ArtARTs36\MergeRequestLinter\Support\DataStructure\Map::missing
     */
    public function testMissing(array $items, string $id, bool $expected): void
    {
        self::assertEquals($expected, (new Map($items))->missing($id));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Support\DataStructure\Map::diff
     */
    public function testDiff(): void
    {
        self::assertEquals(
            ['one' => 1],
            iterator_to_array((new Map(['one' => 1, 't' => 2]))->diff(new Map(['t' => 2])))
        );
    }

    public function providerForTestFirst(): array
    {
        return [
            [
                new Map([
                    'one' => 1,
                ]),
                1,
            ],
            [
                new Map([
                    'one' => 1,
                    'two' => 2,
                ]),
                1,
            ],
            [
                new Map([]),
                null,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Support\DataStructure\Map::first
     * @dataProvider providerForTestFirst
     */
    public function testFirst(Map $map, mixed $expected): void
    {
        self::assertEquals($expected, $map->first());
    }
}
