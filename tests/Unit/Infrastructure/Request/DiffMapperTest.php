<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Request;

use ArtARTs36\MergeRequestLinter\Domain\Request\DiffType;
use ArtARTs36\MergeRequestLinter\Infrastructure\Request\DiffMapper;
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
                        'type' => DiffType::NOT_CHANGES->value,
                        'content' => 'test1',
                    ],
                    [
                        'type' => DiffType::OLD->value,
                        'content' => 'test2',
                    ],
                    [
                        'type' => DiffType::NEW->value,
                        'content' => 'test3',
                    ],
                ],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Request\DiffMapper::map
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
