<?php

namespace ArtARTs36\MergeRequestLinter\Contracts;

/**
 * Interface for collections.
 */
interface Arrayable extends \Countable
{
    /**
     * Get count of items.
     */
    public function count(): int;

    /**
     * Determine has value.
     */
    public function has(mixed $value): bool;

    /**
     * Determine has any value of {values}.
     * @param array<mixed> $values
     */
    public function hasAny(array $values): bool;
}
