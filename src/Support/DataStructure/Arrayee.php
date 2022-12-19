<?php

namespace ArtARTs36\MergeRequestLinter\Support\DataStructure;

use Traversable;

/**
 * @template K of array-key
 * @template V
 * @template-implements Collection<K, V>
 */
class Arrayee implements Collection
{
    use CountProxy;

    /**
     * @param array<K, V> $items
     */
    public function __construct(
        private array $items,
    ) {
        //
    }

    public function getIterator(): Traversable
    {
        return new \ArrayIterator($this->items);
    }

    public function containsAny(iterable $values): bool
    {
        foreach ($values as $value) {
            if (in_array($value, $this->items)) {
                return true;
            }
        }

        return false;
    }
}
