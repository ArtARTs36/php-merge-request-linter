<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Support;

use ArtARTs36\MergeRequestLinter\Support\Map;
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
     * @covers \ArtARTs36\MergeRequestLinter\Support\Map::fromList
     */
    public function testFromList(array $items, array $expected): void
    {
        self::assertEquals($expected, (array) Map::fromList($items)->getIterator());
    }
}
