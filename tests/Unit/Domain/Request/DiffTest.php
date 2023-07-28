<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Domain\Request;

use ArtARTs36\MergeRequestLinter\Domain\Request\Diff;
use ArtARTs36\MergeRequestLinter\Domain\Request\DiffFragment;
use ArtARTs36\MergeRequestLinter\Domain\Request\DiffType;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use ArtARTs36\Str\Str;

final class DiffTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Domain\Request\Diff::changesCount
     * @covers \ArtARTs36\MergeRequestLinter\Domain\Request\Diff::__construct
     */
    public function testChangesCount(): void
    {
        $diff = Diff::fromList([
            new DiffFragment(DiffType::NEW, Str::fromEmpty()),
            new DiffFragment(DiffType::NOT_CHANGES, Str::fromEmpty()),
        ]);

        self::assertEquals(1, $diff->changesCount());
    }
}
