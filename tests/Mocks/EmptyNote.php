<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Note\AbstractNote;
use ArtARTs36\MergeRequestLinter\Note\NoteSeverity;

final class EmptyNote extends AbstractNote
{
    public function getSeverity(): NoteSeverity
    {
        return NoteSeverity::Normal;
    }

    public function getDescription(): string
    {
        return '';
    }
}
