<?php

namespace ArtARTs36\MergeRequestLinter\Support\DataStructure\ArrayableWrapper;

use ArtARTs36\MergeRequestLinter\Contracts\Arrayable;

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
}
