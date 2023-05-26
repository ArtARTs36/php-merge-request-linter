<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Domain\Note\AbstractNote;
use ArtARTs36\MergeRequestLinter\Domain\Note\Note;
use ArtARTs36\MergeRequestLinter\Domain\Note\NoteSeverity;

final class EmptyNote extends AbstractNote
{
    public function getSeverity(): NoteSeverity
    {
        return NoteSeverity::Error;
    }

    public function getDescription(): string
    {
        return '';
    }

    public function withSeverity(NoteSeverity $severity): Note
    {
        return $this;
    }
}
