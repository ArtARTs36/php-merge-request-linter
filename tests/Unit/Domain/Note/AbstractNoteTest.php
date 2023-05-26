<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Domain\Note;

use ArtARTs36\MergeRequestLinter\Domain\Note\AbstractNote;
use ArtARTs36\MergeRequestLinter\Domain\Note\Note;
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
            protected NoteSeverity $severity = NoteSeverity::Fatal;

            public function getDescription(): string
            {
                return '';
            }

            public function withSeverity(NoteSeverity $severity): Note
            {
                $this->severity = $severity;

                return $this;
            }
        };

        self::assertEquals(NoteSeverity::Fatal, $note->getSeverity());
    }
}
