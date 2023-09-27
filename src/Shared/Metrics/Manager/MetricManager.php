<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Manager;

use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\MetricSample;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\MetricSubject;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\Record;

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

    /**
     * Flush records to persistent storage.
     */
    public function flush(string $id): void;
}
