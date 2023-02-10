<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments;

use ArtARTs36\MergeRequestLinter\Common\Contracts\DataStructure\Map;

final class MapEnvironment extends AbstractEnvironment
{
    /**
     * @param Map<string, mixed> $map
     */
    public function __construct(
        private readonly Map $map,
    ) {
        //
    }

    protected function get(string $key): mixed
    {
        return ($value = $this->map->get($key)) === null ? false : $value;
    }
}
