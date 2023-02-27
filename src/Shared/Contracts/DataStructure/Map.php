<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Contracts\DataStructure;

use ArtARTs36\MergeRequestLinter\Shared\Contracts\HasDebugInfo;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;

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

    /**
     * Convert Map to native array.
     * @return array<K, V>
     */
    public function toArray(): array;
}
