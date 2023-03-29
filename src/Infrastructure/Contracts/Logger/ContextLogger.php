<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Logger;

use Psr\Log\LoggerInterface;

/**
 * Context logger.
 */
interface ContextLogger extends LoggerInterface
{
    /**
     * Share log context.
     */
    public function shareContext(string $key, mixed $value): void;

    /**
     * Clear log context by key.
     */
    public function clearContext(string $key): void;
}
