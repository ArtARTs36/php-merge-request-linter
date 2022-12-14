<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Support;

use ArtARTs36\MergeRequestLinter\Support\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class MapTest extends TestCase
{
    public function providerForTestFromList(): array
    {
        return [
            [
                [
                    'value1',
                    'value2',
                ],
                [
                    'value1' => 'value1',
                    'value2' => 'value2',
                ],
            ],
        ];
    }

    /**
     * @dataProvider providerForTestFromList
     * @covers \ArtARTs36\MergeRequestLinter\Support\DataStructure\Map::fromList
     */
    public function testFromList(array $items, array $expected): void
    {
        self::assertEquals($expected, (array) Map::fromList($items)->getIterator());
    }

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
}
