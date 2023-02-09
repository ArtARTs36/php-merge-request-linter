<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Request;

class Change
{
    /**
     * @param string $file
     */
    public function __construct(
        public readonly string $file,
        public readonly Diff $diff,
    ) {
        //
    }

    public function __toString(): string
    {
        return $this->file;
    }
}
