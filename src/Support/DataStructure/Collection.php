<?php

namespace ArtARTs36\MergeRequestLinter\Support\DataStructure;

use IteratorAggregate;

/**
 * Interface for Collections.
 * @template K of array-key
 * @template V
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
}
