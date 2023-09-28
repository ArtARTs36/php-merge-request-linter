<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Logger;

use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\MetricSubject;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Registry\CollectorRegisterer;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\Counter;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

final class MetricableLogger implements LoggerInterface
{
    use LoggerTrait;

    public function __construct(
        private readonly Counter $logsCounter,
    ) {
    }

    public static function create(CollectorRegisterer $metrics): self
    {
        $counter = new Counter(new MetricSubject('logger', 'logs_count', 'Logs count'));

        $metrics->register($counter);

        return new self($counter);
    }

    public function log($level, $message, array $context = []): void
    {
        $this->logsCounter->inc();
    }
}
