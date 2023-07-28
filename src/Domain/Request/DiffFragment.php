<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Request;

use ArtARTs36\Str\Str;

/**
 * @codeCoverageIgnore
 */
class DiffFragment
{
    public function __construct(
        public readonly DiffType $type,
        public readonly Str $content,
    ) {
    }

    public function hasChanges(): bool
    {
        return $this->type !== DiffType::NOT_CHANGES;
    }
}
