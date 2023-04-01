<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Logger;

use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\Counter;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\IncCounter;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\MetricManager;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\MetricSubject;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

final class MetricableLogger implements LoggerInterface
{
    use LoggerTrait;

    public function __construct(
        private readonly Counter $logsCounter,
    ) {
        //
    }

    public static function create(MetricManager $manager): self
    {
        $counter = new IncCounter();

        $manager->add(new MetricSubject('logger_logs_count', '[Logger] Logs count'), $counter);

        return new self($counter);
    }

    public function log($level, $message, array $context = []): void
    {
        $this->logsCounter->inc();
    }
}
