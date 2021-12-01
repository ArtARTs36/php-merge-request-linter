<?php

namespace ArtARTs36\MergeRequestLinter\Support;

/**
 * @template T
 */
class Collection implements \Countable, \IteratorAggregate
{
    /**
     * @param array<T> $items
     */
    public function __construct(protected array $items)
    {
        //
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    /**
     * @return iterable<T>
     */
    public function getIterator(): iterable
    {
        return new \ArrayIterator($this->items);
    }

    public function implode(string $sep): string
    {
        return implode($sep, $this->items);
    }
}
