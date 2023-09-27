<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Value;

use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Map;

/**
 * Interface for managing metrics (time execution, etc.).
 */
interface MetricManager
{
    /**
     * Register metric subject.
     */
    public function register(MetricSubject $subject): void;

    /**
     * Register metric subject with sample.
     */
    public function registerWithSample(MetricSubject $subject, MetricSample $sample): void;

    /**
     * Add new metric sample.
     * @return $this
     */
    public function add(string $subjectIdentity, MetricSample $value): self;

    /**
     * Describe metrics.
     * @return Map<string, Record>
     */
    public function describe(): Map;
}
