<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Request;

use ArtARTs36\Str\Str;

class DiffLine
{
    public function __construct(
        public readonly DiffType $type,
        public readonly Str      $content,
    ) {
        //
    }

    public function isOld(): bool
    {
        return $this->type === DiffType::OLD;
    }

    public function isNew(): bool
    {
        return $this->type === DiffType::NEW;
    }

    public function isNotChanges(): bool
    {
        return $this->type === DiffType::NOT_CHANGES;
    }

    public function hasChanges(): bool
    {
        return ! $this->isNotChanges();
    }
}
