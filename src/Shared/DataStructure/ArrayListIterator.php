<?php

namespace ArtARTs36\MergeRequestLinter\Shared\DataStructure;

class ArrayListIterator implements \Iterator
{
    private int $index = 0;

    private mixed $currentValue = false;

    public function __construct(
        private array $items,
    ) {
        //
    }

    public function current(): mixed
    {
        return $this->currentValue;
    }

    public function next(): void
    {
        $this->currentValue = next($this->items);

        ++$this->index;
    }

    public function key(): mixed
    {
        return $this->index;
    }

    public function valid(): bool
    {
        return $this->currentValue !== false;
    }

    public function rewind(): void
    {
        $this->currentValue = reset($this->items);

        $this->index = 0;
    }
}
