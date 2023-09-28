<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Registry;

use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\Collector;

/**
 * Interface for managing collectors (time execution, etc.).
 */
interface CollectorRegistry extends CollectorRegisterer
{
    /**
     * Describe metrics.
     * @return Map<string, Collector>
     */
    public function describe(): Map;
}
