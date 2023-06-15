<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\DataStructure;

use ArtARTs36\MergeRequestLinter\Shared\DataStructure\RawArray;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ArrTest extends TestCase
{
    public function providerForTestPath(): array
    {
        return [
            [
                [
                    'k' => [
                        1 => [
                            2 => 3,
                        ],
                    ],
                ],
                'k.1.2',
                3,
            ],
            [
                [
                    'k' => [
                        1 => [
                            2 => 3,
                        ],
                    ],
                ],
                'k.1',
                [2 => 3],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\RawArray::path
     *
     * @dataProvider providerForTestPath
     */
    public function testPath(array $array, string $path, mixed $expected): void
    {
        self::assertEquals($expected, RawArray::path($array, $path));
    }
}
