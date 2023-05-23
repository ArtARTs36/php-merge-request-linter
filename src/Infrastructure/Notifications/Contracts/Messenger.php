<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Contracts;

use ArtARTs36\MergeRequestLinter\Domain\Notifications\Channel;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Exceptions\NotificationSendException;

/**
 * Interface for different Messengers.
 */
interface Messenger
{
    /**
     * Send message to channel.
     * @throws NotificationSendException
     */
    public function send(Channel $channel, string $message, bool $withSound): void;
}
