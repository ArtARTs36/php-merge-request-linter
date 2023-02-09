<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Note;

use ArtARTs36\MergeRequestLinter\Contracts\Linter\Note;

abstract class AbstractNote implements Note
{
    protected const SEVERITY = NoteSeverity::Normal;

    public function getSeverity(): NoteSeverity
    {
        return static::SEVERITY;
    }

    public function __toString(): string
    {
        return $this->getDescription();
    }
}
