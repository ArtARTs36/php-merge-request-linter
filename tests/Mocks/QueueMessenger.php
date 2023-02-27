<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Domain\Notifications\Channel;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Contracts\Messenger;

class QueueMessenger implements Messenger
{
    /** @var array<array{Channel, string}> */
    private array $queue = [];

    public function send(Channel $channel, string $message): void
    {
        $this->queue[] = [
            $channel,
            $message,
        ];
    }

    /**
     * @return array<array{Channel, string}>
     */
    public function getQueue(): array
    {
        return $this->queue;
    }
}
