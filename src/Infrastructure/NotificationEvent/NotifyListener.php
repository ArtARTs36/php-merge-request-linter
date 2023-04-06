<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\NotificationEvent;

use ArtARTs36\MergeRequestLinter\Domain\Configuration\NotificationEventMessage;
use ArtARTs36\ContextLogger\ContextLogger;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Contracts\Notifier;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Notifier\MessageCreator;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;

class NotifyListener implements Listener
{
    public function __construct(
        private readonly Notifier                 $notifier,
        private readonly NotificationEventMessage $message,
        private readonly MessageCreator           $messageCreator,
        private readonly ContextLogger            $logger,
    ) {
        //
    }

    public function handle(object $event): void
    {
        $message = $this->messageCreator->create(
            $this->message->template,
            new ArrayMap(get_object_vars($event)),
        );

        $this->logger->shareContext('message_id', $message->id);

        $this->notifier->notify(
            $this->message->channel,
            $message,
        );

        $this->logger->clearContext('message_id');
    }
}
