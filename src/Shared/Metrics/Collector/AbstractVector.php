<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector;

/**
 * @template C of Collector
 */
abstract class AbstractVector extends AbstractCollector
{
    /** @var array<string, C> */
    private array $collectors = [];

    /**
     * @param callable(array<string, string> $labels): C $factory
     * @param array<string, string> $labels
     * @return C
     */
    final protected function attach(callable $factory, array $labels): Collector
    {
        $labelsHash = LabelsHash::hash($labels);

        if (array_key_exists($labelsHash, $this->collectors)) {
            return $this->collectors[$labelsHash];
        }

        $collector = $factory($labels);

        $this->collectors[$labelsHash] = $collector;

        return $collector;
    }

    public function getSamples(): array
    {
        $samples = [];

        foreach ($this->collectors as $collector) {
            foreach ($collector->getSamples() as $sample) {
                $samples[] = $sample;
            }
        }

        return $samples;
    }
}
