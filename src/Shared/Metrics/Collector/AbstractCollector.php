<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector;

abstract class AbstractCollector implements Collector
{
    public function __construct(
        private readonly MetricSubject $subject,
    ) {
    }

    public function getSubject(): MetricSubject
    {
        return $this->subject;
    }
}
