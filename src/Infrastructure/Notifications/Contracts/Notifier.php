<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Contracts;

use ArtARTs36\MergeRequestLinter\Domain\Notifications\Channel;
use ArtARTs36\MergeRequestLinter\Domain\Notifications\Message;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Exceptions\MessengerNotFoundException;

/**
 * Notifier.
 */
interface Notifier
{
    /**
     * Notify channel.
     * @throws MessengerNotFoundException
     */
    public function notify(Channel $channel, Message $message): void;
}
