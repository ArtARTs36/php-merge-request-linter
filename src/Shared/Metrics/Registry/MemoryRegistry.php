<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Registry;

use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\Collector;

final class MemoryRegistry implements CollectorRegistry
{
    /**
     * @var array<string, Collector>
     */
    private array $collectors = [];

    public function getOrRegister(Collector $collector): Collector
    {
        $key = $collector->getSubject()->identity();

        if (array_key_exists($key, $this->collectors)) {
            if (get_class($this->collectors[$key]) !== get_class($collector)) {
                throw new CollectorAlreadyRegisteredException(sprintf(
                    'Already registered collector "%s" with type "%s". Expected type: %s',
                    $key,
                    $this->collectors[$key]::class,
                    $collector::class,
                ));
            }

            return $this->collectors[$key];
        }

        $this->register($collector);

        return $collector;
    }

    public function register(Collector $collector): void
    {
        $key = $collector->getSubject()->identity();

        if (array_key_exists($key, $this->collectors)) {
            throw new CollectorAlreadyRegisteredException(sprintf(
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
