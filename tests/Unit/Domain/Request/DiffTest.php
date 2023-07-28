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
     * @covers \ArtARTs36\MergeRequestLinter\Domain\Request\Diff::empty
     */
    public function testEmpty(): void
    {
        $diff = Diff::empty();

        self::assertTrue($diff->allFragments->isEmpty());
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Domain\Request\Diff::fromList
     * @covers \ArtARTs36\MergeRequestLinter\Domain\Request\Diff::__construct
     */
    public function testFromList(): void
    {
        $diff = Diff::fromList([
            new DiffFragment(DiffType::NEW, Str::fromEmpty()),
            new DiffFragment(DiffType::NEW, Str::fromEmpty()),
            new DiffFragment(DiffType::OLD, Str::fromEmpty()),
            new DiffFragment(DiffType::OLD, Str::fromEmpty()),
            new DiffFragment(DiffType::OLD, Str::fromEmpty()),
            new DiffFragment(DiffType::NOT_CHANGES, Str::fromEmpty()),
        ]);

        self::assertEquals(
            [2, 3, 1],
            [
                $diff->newFragments->count(),
                $diff->oldFragments->count(),
                $diff->notChangedFragments->count(),
            ],
        );
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Domain\Request\Diff::changesCount
     * @covers \ArtARTs36\MergeRequestLinter\Domain\Request\Diff::__construct
     */
    public function testChangesCount(): void
    {
        $diff = Diff::fromList([
            new DiffFragment(DiffType::NEW, Str::fromEmpty()),
            new DiffFragment(DiffType::OLD, Str::fromEmpty()),
            new DiffFragment(DiffType::NOT_CHANGES, Str::fromEmpty()),
        ]);

        self::assertEquals(2, $diff->changesCount());
    }
}
