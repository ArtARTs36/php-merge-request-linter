<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Value;

class Record
{
    /**
     * @param array<MetricSample> $samples
     */
    public function __construct(
        public readonly MetricSubject      $subject,
        public array                       $samples,
    ) {
    }
}
