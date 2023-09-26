<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Value;

readonly class Record
{
    public function __construct(
        public MetricSubject      $subject,
        public Metric             $value,
        public \DateTimeInterface $date,
    ) {
    }
}
