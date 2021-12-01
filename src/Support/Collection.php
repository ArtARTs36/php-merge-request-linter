<?php

namespace ArtARTs36\MergeRequestLinter\Support;

/**
 * @template T
 */
class Collection implements \IteratorAggregate
{
    /**
     * @param array<T> $items
     */
    public function __construct(protected array $items)
    {
        //
    }

    /**
     * @return iterable<T>
     */
    public function getIterator(): iterable
    {
        return new \ArrayIterator($this->items);
    }
}
