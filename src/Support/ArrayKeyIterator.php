<?php

namespace ArtARTs36\MergeRequestLinter\Support;

/**
 * @template K of array-key
 * @template V
 * @template-extends \ArrayIterator<K, V>
 */
class ArrayKeyIterator extends \ArrayIterator
{
    /**
     * @return K
     */
    public function current(): mixed
    {
        return $this->key();
    }
}
