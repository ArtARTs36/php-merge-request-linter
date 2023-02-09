<?php

namespace ArtARTs36\MergeRequestLinter\Contracts\DataStructure;

use ArtARTs36\MergeRequestLinter\Contracts\HasDebugInfo;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Arrayee;

/**
 * Interface for Collections.
 * @template K of array-key
 * @template V
 * @template-extends Collection<K, V>
 */
interface Map extends Collection, HasDebugInfo
{
    /**
     * Get value by key.
     * @return V|null
     */
    public function get(string $id);

    /**
     * Get keys.
     * @return Arrayee<int, K>
     */
    public function keys(): Arrayee;
}
