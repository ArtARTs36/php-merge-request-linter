<?php

namespace ArtARTs36\MergeRequestLinter\Support\ArrayableWrapper;

use ArtARTs36\MergeRequestLinter\Contracts\Arrayable;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Map;

class MapWrapper implements Arrayable
{
    /**
     * @param Map<string|int, mixed> $map
     */
    public function __construct(
        private Map $map,
    ) {
        //
    }

    public function count(): int
    {
        return $this->map->count();
    }

    public function has(mixed $value): bool
    {
        return $this->map->search($value) !== null;
    }
}
