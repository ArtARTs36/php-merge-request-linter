<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Domain\Request;

use ArtARTs36\MergeRequestLinter\Domain\Request\DiffLine;
use ArtARTs36\MergeRequestLinter\Domain\Request\DiffType;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use ArtARTs36\Str\Str;

final class DiffLineTest extends TestCase
{
    public function providerForTestHasChanges(): array
    {
        return [
            [
                DiffType::NEW,
                'content',
                true,
            ],
            [
                DiffType::OLD,
                'content',
                true,
            ],
            [
                DiffType::NOT_CHANGES,
                'content',
                false,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Domain\Request\DiffLine::hasChanges
     * @covers \ArtARTs36\MergeRequestLinter\Domain\Request\DiffLine::__construct
     * @dataProvider providerForTestHasChanges
     */
    public function testHasChanges(DiffType $diffType, string $content, bool $expected): void
    {
        $diffLine = new DiffLine($diffType, Str::make($content));

        self::assertEquals($expected, $diffLine->hasChanges());
    }
}
