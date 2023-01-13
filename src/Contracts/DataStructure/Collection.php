<?php

namespace ArtARTs36\MergeRequestLinter\Contracts\DataStructure;

use IteratorAggregate;

/**
 * Interface for Collections.
 * @template K of array-key
 * @template Vm
 * @template-extends IteratorAggregate<K, V>
 */
interface Collection extends IteratorAggregate, \Countable
{
    /**
     * Check contains any of {values}.
     * @param iterable<V> $values
     */
    public function containsAny(iterable $values): bool;

    /**
     * Check contains value.
     * @param V $value
     */
    public function contains(mixed $value): bool;

    /**
     * Check contains all of {values}.
     * @param iterable<V> $values
     */
    public function containsAll(iterable $values): bool;

    /**
     * Check collection is empty.
     */
    public function isEmpty(): bool;

    /**
     * Convert Collection to debug view string.
     */
    public function debugView(): string;
}
