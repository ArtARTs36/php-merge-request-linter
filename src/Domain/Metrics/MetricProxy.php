<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Metrics;

class MetricProxy implements Metric
{
    private ?Metric $metric = null;

    /**
     * @param \Closure(): Metric $callback
     */
    public function __construct(
        private readonly \Closure $callback,
    ) {
        //
    }

    public function getMetricValue(): string
    {
        return $this->retrieve()->getMetricValue();
    }

    public function retrieveIfNotRetrieved(): void
    {
        $this->retrieve();
    }

    private function retrieve(): Metric
    {
        if ($this->metric === null) {
            $this->metric = ($this->callback)();
        }

        return $this->metric;
    }
}
