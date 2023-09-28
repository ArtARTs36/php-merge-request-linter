<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector;

interface Collector
{
    public function getSubject(): MetricSubject;

    public function getMetricType(): MetricType;

    /**
     * @return array<Sample>
     */
    public function getSamples(): array;
}
