<?php

namespace ArtARTs36\MergeRequestLinter\Request\Data;

class Change
{
    public function __construct(
        public readonly string $file,
    ) {
        //
    }

    public function __toString(): string
    {
        return $this->file;
    }
}
