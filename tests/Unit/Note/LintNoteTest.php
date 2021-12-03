<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Note;

use ArtARTs36\MergeRequestLinter\Note\LintNote;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class LintNoteTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Note\LintNote::getDescription
     */
    public function testGetDescription(): void
    {
        self::assertEquals('Test-description', (new LintNote('Test-description'))->getDescription());
    }
}
