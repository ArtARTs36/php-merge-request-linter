<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Metrics\Manager;

use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Domain\Metrics\Metric;
use ArtARTs36\MergeRequestLinter\Domain\Metrics\MetricManager;
use ArtARTs36\MergeRequestLinter\Domain\Metrics\MetricSubject;
use ArtARTs36\MergeRequestLinter\Domain\Metrics\Record;
use ArtARTs36\MergeRequestLinter\Shared\Time\Clock;
use Psr\Clock\ClockInterface;

class MemoryMetricManager implements MetricManager
{
    /**
     * @var array<Record>
     */
    private array $records = [];

    public function __construct(
        private readonly ClockInterface $clock = new Clock(),
    ) {
        //
    }

    public function add(MetricSubject $subject, Metric $value): self
    {
        $this->records[] = new Record(
            $subject,
            $value,
            $this->clock->now(),
        );

        return $this;
    }

    public function describe(): Arrayee
    {
        return new Arrayee($this->records);
    }
}
