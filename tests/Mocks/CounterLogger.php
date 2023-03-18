<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

class CounterLogger implements LoggerInterface
{
    use LoggerTrait;

    private array $messages = [];

    public function log($level, $message, array $context = []): void
    {
        $this->messages[] = $message;
    }

    /**
     * @return array<string>
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    public function hasMessage(string $message): bool
    {
        return in_array($message, $this->messages);
    }

    public function getMessagesCount(): int
    {
        return count($this->messages);
    }
}
