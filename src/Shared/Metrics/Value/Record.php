<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Value;

readonly class Record
{
    public function __construct(
        public MetricSubject      $subject,
        private Metric            $value,
        public \DateTimeInterface $date,
    ) {
        //
    }

    public function getValue(): string
    {
        return $this->value->getMetricValue();
    }
}
