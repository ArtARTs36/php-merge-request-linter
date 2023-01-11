<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Support\DataStructure;

use ArtARTs36\MergeRequestLinter\Support\DataStructure\ArrayMap;
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
     * @covers \ArtARTs36\MergeRequestLinter\Support\DataStructure\ArrayMap::get
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
     * @covers \ArtARTs36\MergeRequestLinter\Support\DataStructure\ArrayMap::has
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
     * @covers \ArtARTs36\MergeRequestLinter\Support\DataStructure\ArrayMap::missing
     */
    public function testMissing(array $items, string $id, bool $expected): void
    {
        self::assertEquals($expected, (new ArrayMap($items))->missing($id));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Support\DataStructure\ArrayMap::diff
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
     * @covers \ArtARTs36\MergeRequestLinter\Support\DataStructure\ArrayMap::first
     * @dataProvider providerForTestFirst
     */
    public function testFirst(ArrayMap $map, mixed $expected): void
    {
        self::assertEquals($expected, $map->first());
    }
}
