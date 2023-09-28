<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Manager;

use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\Collector;

final class MemoryMetricManager implements MetricManager
{
    /**
     * @var array<string, Collector>
     */
    private array $collectors = [];

    public function getOrRegister(string $key, callable $collectorCreator): Collector
    {
        if (array_key_exists($key, $this->collectors)) {
            return $this->collectors[$key];
        }

        $collector = $collectorCreator();

        $this->register($collector);

        return $collector;
    }

    public function register(Collector $collector): void
    {
        $key = $collector->getSubject()->identity();

        if (array_key_exists($key, $this->collectors)) {
            throw new \LogicException(sprintf(
                'Collector for metric with key "%s" already registered',
                $key,
            ));
        }

        $this->collectors[$key] = $collector;
    }

    public function describe(): Map
    {
        return new ArrayMap($this->collectors);
    }
}
