<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Registry;

use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\Collector;

/**
 * Interface for managing metrics (time execution, etc.).
 */
interface CollectorRegisterer
{
    /**
     * @template C of Collector
     * @param C $collector
     * @return C
     */
    public function getOrRegister(Collector $collector): Collector;

    /**
     * Register collector.
     */
    public function register(Collector $collector): void;
}
