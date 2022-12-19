<?php

namespace ArtARTs36\MergeRequestLinter\Support\ArrayableWrapper;

use ArtARTs36\MergeRequestLinter\Contracts\Arrayable;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Set;

class ArrayWrapper implements Arrayable
{
    /**
     * @param array<mixed> $array
     */
    public function __construct(
        private array $array,
    ) {
        //
    }

    public function count(): int
    {
        return count($this->array);
    }

    public function has(mixed $value): bool
    {
        return in_array($value, $this->array);
    }

    public function hasAny(array $values): bool
    {
        return Set::fromList($this->array)->containsAny($values);
    }
}
