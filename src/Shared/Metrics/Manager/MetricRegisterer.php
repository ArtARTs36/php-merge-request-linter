<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Manager;

use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\MetricSample;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\MetricSubject;

/**
 * Interface for managing metrics (time execution, etc.).
 */
interface MetricRegisterer
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
}
