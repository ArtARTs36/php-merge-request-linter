<?php

namespace ArtARTs36\MergeRequestLinter\Support\ArrayableWrapper;

use ArtARTs36\MergeRequestLinter\Contracts\Arrayable;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Set;

class SetWrapper implements Arrayable
{
    /**
     * @param Set<mixed> $set
     */
    public function __construct(
        private Set $set,
    ) {
        //
    }

    public function count(): int
    {
        return $this->set->count();
    }

    public function has(mixed $value): bool
    {
        return $this->set->has($value);
    }
}
