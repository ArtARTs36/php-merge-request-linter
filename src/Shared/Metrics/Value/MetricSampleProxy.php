<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Value;

class MetricSampleProxy extends AbstractMetricSample implements MetricSample
{
    private ?MetricSample $metric = null;

    /**
     * @param \Closure(): MetricSample $callback
     */
    public function __construct(
        private readonly \Closure $callback,
        protected array $labels = [],
    ) {
    }

    public function getMetricType(): MetricType
    {
        return $this->retrieve()->getMetricType();
    }

    public function getMetricValue(): string
    {
        return $this->retrieve()->getMetricValue();
    }

    private function retrieve(): MetricSample
    {
        if ($this->metric === null) {
            $this->metric = ($this->callback)();
        }

        return $this->metric;
    }
}
