<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use PHPUnit\Framework\Assert;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

class CounterLogger implements LoggerInterface
{
    use LoggerTrait;

    private array $messages = [];

    private ?array $expectMessages = null;

    public function log($level, $message, array $context = []): void
    {
        if ($this->expectMessages !== null) {
            Assert::assertEquals(array_shift($this->expectMessages), $message);
        }

        $this->messages[] = $message;
    }

    public function expect(array $messages): void
    {
        $this->expectMessages = $messages;
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
