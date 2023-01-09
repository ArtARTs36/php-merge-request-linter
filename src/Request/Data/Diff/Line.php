<?php

namespace ArtARTs36\MergeRequestLinter\Request\Data\Diff;

use ArtARTs36\Str\Str;

class Line
{
    public function __construct(
        private readonly Type $type,
        public readonly Str $content,
    ) {
        //
    }

    public function isOld(): bool
    {
        return $this->type === Type::OLD;
    }

    public function isNew(): bool
    {
        return $this->type === Type::NEW;
    }

    public function isNotChanges(): bool
    {
        return $this->type === Type::NOT_CHANGES;
    }

    public function hasChanges(): bool
    {
        return ! $this->isNotChanges();
    }
}
