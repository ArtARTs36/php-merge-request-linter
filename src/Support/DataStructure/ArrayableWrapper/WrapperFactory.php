<?php

namespace ArtARTs36\MergeRequestLinter\Support\DataStructure\ArrayableWrapper;

use ArtARTs36\MergeRequestLinter\Contracts\Arrayable;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Set;

class WrapperFactory
{
    /**
     * @param array<mixed>|Set<mixed>|Map<string|int, mixed> $iterable
     */
    public function create(array|Set|Map $iterable): Arrayable
    {
        if (is_array($iterable)) {
            return new ArrayWrapper($iterable);
        }

        if ($iterable instanceof Set) {
            return new SetWrapper($iterable);
        }

        return new MapWrapper($iterable);
    }
}
