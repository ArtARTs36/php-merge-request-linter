<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Contracts;

use ArtARTs36\MergeRequestLinter\Domain\Notifications\Channel;
use ArtARTs36\MergeRequestLinter\Domain\Notifications\Message;

/**
 * Notifier.
 */
interface Notifier
{
    /**
     * Notify channel.
     */
    public function notify(Channel $channel, Message $message): void;
}
