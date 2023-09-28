<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector;

final class Counter extends LabeledCollector
{
    /**
     * @param array<string, string> $labels
     */
    public function __construct(
        MetricSubject $subject,
        array $labels = [],
        private int $value = 0,
    ) {
        parent::__construct($subject, $labels);
    }

    public function inc(int $val = 1): void
    {
        $this->value += $val;
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
        return MetricType::Counter;
    }
}
