<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Notifications;

use ArtARTs36\MergeRequestLinter\Domain\Configuration\NotificationEventMessage;
use ArtARTs36\MergeRequestLinter\Domain\Notifications\Channel;
use ArtARTs36\MergeRequestLinter\Domain\Notifications\Message;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Contracts\Notifier;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;

class EventHandler
{
    public function __construct(
        private readonly Notifier                 $notifier,
        private readonly NotificationEventMessage $message,
    ) {
        //
    }

    public function handle(object $event): void
    {
        $this->notifier->notify(
            $this->message->channel,
            new Message(
                $this->message->template,
                new ArrayMap(get_object_vars($event)),
            ),
        );
    }
}
