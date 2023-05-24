<?php

namespace ArtARTs36\MergeRequestLinter\Shared\DataStructure;

use ArtARTs36\MergeRequestLinter\Shared\Contracts\HasDebugInfo;

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
     * Check id exists.
     */
    public function has(string $id): bool;

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
