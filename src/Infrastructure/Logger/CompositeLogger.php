<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Logger;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

final class CompositeLogger implements LoggerInterface
{
    use LoggerTrait;

    /**
     * @param iterable<LoggerInterface> $loggers
     */
    public function __construct(
        private readonly iterable $loggers,
    ) {
    }

    public function log($level, \Stringable|string $message, array $context = []): void
    {
        foreach ($this->loggers as $logger) {
            $logger->log($level, $message, $context);
        }
    }
}
