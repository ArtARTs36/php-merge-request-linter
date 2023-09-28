<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector;

final class Gauge extends LabeledCollector
{
    public function __construct(
        MetricSubject $subject,
        array $labels,
        private float $value = 0,
    ) {
        parent::__construct($subject, $labels);
    }

    public function set(float $value): void
    {
        $this->value = $value;
    }

    public function getSamples(): array
    {
        return [
            new Sample($this->value, $this->labels),
        ];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getMetricType(): MetricType
    {
        return MetricType::Gauge;
    }
}
