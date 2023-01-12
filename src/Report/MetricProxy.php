<?php

namespace ArtARTs36\MergeRequestLinter\Report;

use ArtARTs36\MergeRequestLinter\Contracts\Report\Metricable;

class MetricProxy implements Metricable
{
    private ?Metricable $metric = null;

    /**
     * @param \Closure(): Metricable $callback
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

    private function retrieve(): Metricable
    {
        if ($this->metric === null) {
            $this->metric = ($this->callback)();
        }

        return $this->metric;
    }
}
