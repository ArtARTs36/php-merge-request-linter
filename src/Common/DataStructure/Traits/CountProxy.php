<?php

namespace ArtARTs36\MergeRequestLinter\Common\DataStructure\Traits;

trait CountProxy
{
    protected ?int $count = null;

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

    public function equalsCount(\Countable $that): bool
    {
        return $this->count() === $that->count();
    }

    public function once(): bool
    {
        return $this->count() === 1;
    }
}
