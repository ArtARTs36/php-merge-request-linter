<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Contracts;

use ArtARTs36\MergeRequestLinter\Domain\Notifications\Channel;

/**
 * Interface for different Messengers.
 */
interface Messenger
{
    /**
     * Send message to channel.
     */
    public function send(Channel $channel, string $message): void;
}