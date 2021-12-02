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
    final public function __construct(protected array $items)
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

    public function diff(self $that): Collection
    {
        return new static(array_diff($this->items, $that->items));
    }

    public function equalsCount(self $that): bool
    {
        return $this->count() === $that->count();
    }

    /**
     * @return T|null
     */
    public function first()
    {
        return $this->items[array_key_first($this->items)] ?? null;
    }
}
