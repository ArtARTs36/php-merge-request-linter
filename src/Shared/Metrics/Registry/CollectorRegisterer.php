<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Registry;

use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\Collector;

/**
 * Interface for managing collectors (time execution, etc.).
 */
interface CollectorRegisterer
{
    /**
     * @template C of Collector
     * @param C $collector
     * @return C
     * @throws CollectorAlreadyRegisteredException if registered collector with different type
     */
    public function getOrRegister(Collector $collector): Collector;

    /**
     * Register collector.
     * @throws CollectorAlreadyRegisteredException
     */
    public function register(Collector $collector): void;
}
