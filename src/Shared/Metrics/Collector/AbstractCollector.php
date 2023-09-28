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

    public function getFirstSampleValue(): null|string|int|float
    {
        $samples = $this->getSamples();

        return isset($samples[0]) ? $samples[0]->value : null;
    }
}
