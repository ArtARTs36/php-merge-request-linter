<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Logger;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

class ContextLogger implements \ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Logger\ContextLogger
{
    use LoggerTrait;

    /** @var array<string, mixed> */
    private array $context = [];

    public function __construct(
        private readonly LoggerInterface $logger,
    ) {
        //
    }

    public function shareContext(string $key, mixed $value): void
    {
        $this->context[$key] = $value;
    }

    public function clearContext(string $key): void
    {
        unset($this->context[$key]);
    }

    public function log($level, $message, array $context = []): void
    {
        $this->logger->log($level, $message, array_merge($this->context, $context));
    }
}
