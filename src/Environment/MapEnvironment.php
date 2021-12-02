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
        return ($value = $this->map->get($key)) === null ? false : $value;
    }
}
