<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Request\Data\Diff;

use ArtARTs36\MergeRequestLinter\Request\Data\Diff\DiffMapper;
use ArtARTs36\MergeRequestLinter\Request\Data\Diff\Type;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class DiffMapperTest extends TestCase
{
    public function providerForTestMap(): array
    {
        return [
            [
                [
                    'test1',
                    '-test2',
                    '+test3',
                ],
                [
                    [
                        'type' => Type::NOT_CHANGES->value,
                        'content' => 'test1',
                    ],
                    [
                        'type' => Type::OLD->value,
                        'content' => 'test2',
                    ],
                    [
                        'type' => Type::NEW->value,
                        'content' => 'test3',
                    ],
                ],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Request\Data\Diff\DiffMapper::map
     * @dataProvider providerForTestMap
     */
    public function testMap(array $response, array $expected): void
    {
        $mapper = new DiffMapper();

        $given = [];

        foreach ($mapper->map($response) as $line) {
            $given[] = [
                'type' => $line->type->value,
                'content' => $line->content,
            ];
        }

        self::assertEquals($expected, $given);
    }
}
