<?php

namespace ArtARTs36\MergeRequestLinter\Support\DataStructure;

trait CountProxy
{
    private ?int $count = null;

    public function count(): int
    {
        if ($this->count === null) {
            $this->count = count($this->items);
        }

        return $this->count;
    }

    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }
}
