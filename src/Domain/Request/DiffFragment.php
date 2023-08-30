<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Request;

use ArtARTs36\Str\Str;

/**
 * @codeCoverageIgnore
 */
readonly class DiffFragment
{
    public function __construct(
        public DiffType $type,
        public Str      $content,
    ) {
    }

    public function hasChanges(): bool
    {
        return $this->type !== DiffType::NOT_CHANGES;
    }
}
