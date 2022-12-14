<?php

namespace ArtARTs36\MergeRequestLinter\Environment;

use ArtARTs36\MergeRequestLinter\Support\DataStructure\Map;

class MapEnvironment extends AbstractEnvironment
{
    /**
     * @param Map<string, mixed> $map
     */
    public function __construct(protected Map $map)
    {
        //
    }

    protected function get(string $key): mixed
    {
        return ($value = $this->map->get($key)) === null ? false : $value;
    }
}
