<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Manager;

use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\Record;

/**
 * Interface for managing metrics (time execution, etc.).
 */
interface MetricManager extends MetricRegisterer
{
    /**
     * Describe metrics.
     * @return Map<string, Record>
     */
    public function describe(): Map;
}
