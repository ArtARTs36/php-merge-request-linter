<?php

namespace ArtARTs36\MergeRequestLinter\Environment;

use ArtARTs36\MergeRequestLinter\Support\DataStructure\ArrayMap;

class MapEnvironment extends AbstractEnvironment
{
    /**
     * @param ArrayMap<string, mixed> $map
     */
    public function __construct(protected ArrayMap $map)
    {
        //
    }

    protected function get(string $key): mixed
    {
        return ($value = $this->map->get($key)) === null ? false : $value;
    }
}
