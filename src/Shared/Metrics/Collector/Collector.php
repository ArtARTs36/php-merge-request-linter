<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector;

/**
 * Interface for Collector.
 */
interface Collector
{
        /**
         * Get subject.
         */
    public function getSubject(): MetricSubject;
    
        /**
         * Get metric type.
         */
    public function getMetricType(): MetricType;

    /**
     * Get samples.
     * @return array<Sample>
     */
    public function getSamples(): array;
}
