<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Manager;

use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\MetricSample;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\MetricManager;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\MetricSubject;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\Record;

class MemoryMetricManager implements MetricManager
{
    /**
     * @var array<string, Record>
     */
    private array $records = [];

    public function register(MetricSubject $subject): void
    {
        $this->records[$subject->identity()] = new Record($subject, []);
    }

    public function registerWithSample(MetricSubject $subject, MetricSample $sample): void
    {
        $this->records[$subject->identity()] = new Record($subject, [$sample]);
    }

    public function add(string $subjectIdentity, MetricSample $value): self
    {
        if (! isset($this->records[$subjectIdentity])) {
            throw new \LogicException(sprintf(
                'Metric with subject identity "%s" not registered',
                $subjectIdentity,
            ));
        }

        $this->records[$subjectIdentity]->samples[] = $value;

        return $this;
    }

    public function describe(): Map
    {
        return new ArrayMap($this->records);
    }
}
