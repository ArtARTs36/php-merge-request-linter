<?php

namespace ArtARTs36\MergeRequestLinter\Support;

/**
 * @template K of array-key
 * @template V
 * @template-implements \IteratorAggregate<K, V>
 */
class ArrayCollection implements \Countable, \IteratorAggregate
{
    /**
     * @param array<K, V> $items
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
     * @return \Traversable<K, V>
     */
    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->items);
    }

    public function implode(string $sep): string
    {
        return implode($sep, $this->items);
    }

    /**
     * @param ArrayCollection<K, V> $that
     * @return ArrayCollection<K, V>
     */
    public function diff(self $that): ArrayCollection
    {
        return new static(array_diff($this->items, $that->items));
    }

    /**
     * @param ArrayCollection<K, V> $that
     */
    public function equalsCount(self $that): bool
    {
        return $this->count() === $that->count();
    }

    /**
     * @return V|null
     */
    public function first()
    {
        return $this->items[array_key_first($this->items)] ?? null;
    }
}
