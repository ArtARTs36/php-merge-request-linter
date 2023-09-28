<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Registry;

use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\Collector;

/**
 * @codeCoverageIgnore
 */
class NullRegistry implements CollectorRegistry
{
    public function getOrRegister(Collector $collector): Collector
    {
        return $collector;
    }

    public function register(Collector $collector): void
    {
        //
    }

    public function describe(): Map
    {
        return new ArrayMap([]);
    }
}
