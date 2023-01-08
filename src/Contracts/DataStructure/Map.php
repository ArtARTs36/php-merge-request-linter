<?php

namespace ArtARTs36\MergeRequestLinter\Contracts\DataStructure;

use ArtARTs36\MergeRequestLinter\Contracts\Collection;

/**
 * Interface for Collections.
 * @template K of array-key
 * @template V
 * @template-extends Collection<K, V>
 */
interface Map extends Collection
{
    /**
     * Get value by key.
     * @return V|null
     */
    public function get(string $id);
}
