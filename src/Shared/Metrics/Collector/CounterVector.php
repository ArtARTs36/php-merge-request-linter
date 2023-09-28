<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector;

/**
 * @template-extends AbstractVector<Counter>
 */
final class CounterVector extends AbstractVector
{
    public static function null(): self
    {
        return new CounterVector(new MetricSubject('', '', ''));
    }

    /**
     * @param array<string, string> $labels
     */
    public static function once(MetricSubject $subject, array $labels): self
    {
        $vector = new CounterVector($subject);

        $vector->add($labels)->inc();

        return $vector;
    }

    /**
     * @param array<string, string> $labels
     */
    public function add(array $labels): Counter
    {
        return $this->attach(function (array $labels) {
            return new Counter($this->getSubject(), $labels);
        }, $labels);
    }

    public function getMetricType(): MetricType
    {
        return MetricType::Counter;
    }
}
