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
                "test1\n-test2\n+test3",
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
            [

                "test1\ntest5\n-test2\n+test3\n+test4",
                [
                    [
                        'type' => DiffType::NOT_CHANGES->value,
                        'content' => "test1\ntest5",
                    ],
                    [
                        'type' => DiffType::OLD->value,
                        'content' => 'test2',
                    ],
                    [
                        'type' => DiffType::NEW->value,
                        'content' => "test3\ntest4",
                    ],
                ],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Request\DiffMapper::map
     * @dataProvider providerForTestMap
     */
    public function testMap(string $response, array $expected): void
    {
        $mapper = new DiffMapper();

        $given = [];

        foreach ($mapper->map($response)->allFragments as $line) {
            $given[] = [
                'type' => $line->type->value,
                'content' => $line->content->__toString(),
            ];
        }

        self::assertEquals($expected, $given);
    }
}
