<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Domain\Note;

use ArtARTs36\MergeRequestLinter\Domain\Note\LintNote;
use ArtARTs36\MergeRequestLinter\Domain\Note\NoteSeverity;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class LintNoteTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Domain\Note\LintNote::getDescription
     * @covers \ArtARTs36\MergeRequestLinter\Domain\Note\LintNote::__construct
     */
    public function testGetDescription(): void
    {
        self::assertEquals('Test-description', (new LintNote('Test-description'))->getDescription());
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Domain\Note\LintNote::withSeverity
     */
    public function testWithSeverity(): void
    {
        self::assertEquals(
            NoteSeverity::Warning,
            (new LintNote(''))->withSeverity(NoteSeverity::Warning)->getSeverity(),
        );
    }
}
