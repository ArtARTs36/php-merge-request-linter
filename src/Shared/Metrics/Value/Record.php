<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Value;

class Record
{
    public function __construct(
        public readonly MetricSubject $subject,
        private readonly Metric $value,
        public readonly \DateTimeInterface $date,
    ) {
        //
    }

    public function getValue(): string
    {
        return $this->value->getMetricValue();
    }
}
