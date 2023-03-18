<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Notifier;

use ArtARTs36\MergeRequestLinter\Domain\Notifications\Channel;
use ArtARTs36\MergeRequestLinter\Domain\Notifications\Message;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Contracts\Notifier;
use Psr\Log\LoggerInterface;

final class LoggableNotifier implements Notifier
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly Notifier $notifier,
    ) {
        //
    }

    public function notify(Channel $channel, Message $message): void
    {
        $context = [
            'message_id' => $message->id,
        ];

        $this->logger->info(
            sprintf('[Notifier] Sending notification to %s', $channel->type->value),
            $context,
        );

        $this->notifier->notify($channel, $message);

        $this->logger->info(
            sprintf('[Notifier] Notification to %s was sent', $channel->type->value),
            $context,
        );
    }
}
