<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Notifications;

use ArtARTs36\MergeRequestLinter\Domain\Configuration\NotificationEventMessage;
use ArtARTs36\MergeRequestLinter\Domain\Notifications\Message;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Condition\OperatorResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Contracts\Notifier;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;

class EventHandler
{
    public function __construct(
        private readonly Notifier                 $notifier,
        private readonly NotificationEventMessage $message,
        private readonly OperatorResolver $operator,
    ) {
        //
    }

    public function handle(object $event): void
    {
        if (! $this->operator->resolve($this->message->conditions)->check($event)) {
            return;
        }

        $this->notifier->notify(
            $this->message->channel,
            new Message(
                $this->message->template,
                new ArrayMap(get_object_vars($event)),
            ),
        );
    }
}
