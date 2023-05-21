<?php

namespace ArtARTs36\MergeRequestLinter\Shared\DataStructure\Traits;

trait CountProxy
{
    /** @var int<0, max>|null */
    protected ?int $count = null;

    /**
     * @return int<0, max>
     */
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
