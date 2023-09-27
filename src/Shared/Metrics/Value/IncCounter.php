<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Value;

final class IncCounter extends AbstractMetricSample implements Counter
{
    /**
     * @param array<string, string> $labels
     */
    public function __construct(
        private int $count = 0,
        protected array $labels = []
    ) {
    }

    /**
     * @param array<string, string> $labels
     */
    public static function one(array $labels = []): self
    {
        return new self(1, $labels);
    }

    /**
     * @param \Countable|array<mixed> $countable
     */
    public static function create(\Countable|array $countable): self
    {
        return new self(count($countable));
    }

    public function inc(): void
    {
        ++$this->count;
    }

    public function getMetricType(): MetricType
    {
        return MetricType::Counter;
    }

    public function getMetricValue(): string
    {
        return "$this->count";
    }
}
