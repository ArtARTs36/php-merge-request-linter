<?php

namespace ArtARTs36\MergeRequestLinter\Note;

use ArtARTs36\MergeRequestLinter\Contracts\Note;

abstract class AbstractNote implements Note
{
    public function __toString(): string
    {
        return $this->getDescription();
    }
}
