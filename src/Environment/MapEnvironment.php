<?php

namespace ArtARTs36\MergeRequestLinter\Environment;

use ArtARTs36\MergeRequestLinter\Support\Map;

class MapEnvironment extends AbstractEnvironment
{
    public function __construct(protected Map $map)
    {
        //
    }

    protected function get(string $key): mixed
    {
        return $this->map->get($key);
    }
}
