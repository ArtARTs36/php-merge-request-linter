<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\ContextLogger\Contracts\ContextLogger;
use PHPUnit\Framework\Assert;
use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;

class MockLogger extends AbstractLogger implements ContextLogger
{
    /** @var array<string, array<string>> */
    private array $logs = [];

    public function shareContext(string $key, mixed $value): void
    {
        //
    }

    public function clearContext(string $key): void
    {
        //
    }

    public function log($level, \Stringable|string $message, array $context = []): void
    {
        $this->logs[$level][] = (string) $message;
    }

    public function assertPushed(string $level, string $message): void
    {
        $pushed = false;

        foreach ($this->logs[$level] ?? [] as $log) {
            if ($log === $message) {
                $pushed = true;

                break;
            }
        }

        Assert::assertTrue(
            $pushed,
            sprintf(
                'Log with level "%s" and message "%s" not found. Exists logs: %s',
                $level,
                $message,
                json_encode($this->logs, JSON_UNESCAPED_SLASHES),
            ),
        );
    }

    public function assertPushedInfo(string $message): void
    {
        $this->assertPushed(LogLevel::INFO, $message);
    }
}
