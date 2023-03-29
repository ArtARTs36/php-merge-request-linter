<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Logger;

use Psr\Log\LoggerTrait;

class NullContextLogger implements \ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Logger\ContextLogger
{
    use LoggerTrait;

    public function shareContext(string $key, mixed $value): void
    {
        //
    }

    public function clearContext(string $key): void
    {
        //
    }

    public function log($level, $message, array $context = []): void
    {
        //
    }
}
