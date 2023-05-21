<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Domain\Request;

use ArtARTs36\MergeRequestLinter\Domain\Request\Change;
use ArtARTs36\MergeRequestLinter\Domain\Request\Diff;
use ArtARTs36\MergeRequestLinter\Domain\Request\DiffLine;
use ArtARTs36\MergeRequestLinter\Domain\Request\DiffType;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use ArtARTs36\Str\Str;

final class ChangeTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Domain\Request\Change::__toString
     * @covers \ArtARTs36\MergeRequestLinter\Domain\Request\Change::__construct
     */
    public function testToString(): void
    {
        $change = new Change('file.txt', new Diff([]));

        self::assertEquals('file.txt', $change->__toString());
    }

    public function providerForTestJsonSerialize(): array
    {
        return [
            [
                'file.txt',
                new Diff([]),
                [
                    'file' => 'file.txt',
                    'diff' => [],
                ],
            ],
            [
                'file.txt',
                new Diff([
                    new DiffLine(DiffType::NEW, Str::make('test1')),
                    new DiffLine(DiffType::NEW, Str::make('test2')),
                    new DiffLine(DiffType::NEW, Str::make('test3')),
                ]),
                [
                    'file' => 'file.txt',
                    'diff' => [
                        'test1',
                        'test2',
                    ],
                ],
            ],
        ];
    }

    /**
     * @dataProvider providerForTestJsonSerialize
     */
    public function testJsonSerialize(string $file, Diff $diff, array $expected): void
    {
        $change = new Change($file, $diff);

        self::assertEquals($expected, $change->jsonSerialize());
    }
}
