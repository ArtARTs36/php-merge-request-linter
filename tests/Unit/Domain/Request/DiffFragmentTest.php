<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Domain\Request;

use ArtARTs36\MergeRequestLinter\Domain\Request\DiffFragment;
use ArtARTs36\MergeRequestLinter\Domain\Request\DiffType;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use ArtARTs36\Str\Str;

final class DiffFragmentTest extends TestCase
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
     * @covers \ArtARTs36\MergeRequestLinter\Domain\Request\DiffFragment::hasChanges
     * @covers \ArtARTs36\MergeRequestLinter\Domain\Request\DiffFragment::__construct
     * @dataProvider providerForTestHasChanges
     */
    public function testHasChanges(DiffType $diffType, string $content, bool $expected): void
    {
        $diffFragment = new DiffFragment($diffType, Str::make($content));

        self::assertEquals($expected, $diffFragment->hasChanges());
    }
}
