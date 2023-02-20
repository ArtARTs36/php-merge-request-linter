<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Domain\Note;

use ArtARTs36\MergeRequestLinter\Domain\Note\AbstractNote;
use ArtARTs36\MergeRequestLinter\Domain\Note\NoteSeverity;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class AbstractNoteTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Domain\Note\AbstractNote::getSeverity
     */
    public function testGetSeverity(): void
    {
        $note = new class () extends AbstractNote {
            protected const SEVERITY = NoteSeverity::Fatal;

            public function getDescription(): string
            {
                return '';
            }
        };

        self::assertEquals(NoteSeverity::Fatal, $note->getSeverity());
    }
}
