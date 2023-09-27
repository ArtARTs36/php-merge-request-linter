<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Logger;

use ArtARTs36\MergeRequestLinter\Shared\Metrics\Manager\MetricRegisterer;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\Counter;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\IncCounter;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\MetricSubject;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

final class MetricableLogger implements LoggerInterface
{
    use LoggerTrait;

    public function __construct(
        private readonly Counter $logsCounter,
    ) {
    }

    public static function create(MetricRegisterer $metrics): self
    {
        $counter = new IncCounter();

        $metrics->registerWithSample(new MetricSubject('logger', 'logs_count', 'Logs count'), $counter);

        return new self($counter);
    }

    public function log($level, $message, array $context = []): void
    {
        $this->logsCounter->inc();
    }
}
