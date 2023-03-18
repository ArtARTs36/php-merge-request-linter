<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\NotificationEvent;

use ArtARTs36\MergeRequestLinter\Domain\Configuration\NotificationEventMessage;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Contracts\Notifier;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Notifier\MessageCreator;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;

class NotifyListener implements Listener
{
    public function __construct(
        private readonly Notifier                 $notifier,
        private readonly NotificationEventMessage $message,
        private readonly MessageCreator           $messageCreator,
    ) {
        //
    }

    public function handle(object $event): void
    {
        $this->notifier->notify(
            $this->message->channel,
            $this->messageCreator->create(
                $this->message->template,
                new ArrayMap(get_object_vars($event)),
            ),
        );
    }
}
