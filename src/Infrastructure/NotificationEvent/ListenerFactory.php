<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\NotificationEvent;

use ArtARTs36\MergeRequestLinter\Domain\Configuration\NotificationEventMessage;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Condition\OperatorResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Contracts\Notifier;

class ListenerFactory
{
    public function __construct(
        private readonly Notifier $notifier,
        private readonly OperatorResolver $operator,
    ) {
        //
    }

    public function create(NotificationEventMessage $message): Listener
    {
        return new ConditionListener(
            $message,
            $this->operator,
            new NotifyListener(
                $this->notifier,
                $message,
            ),
        );
    }
}
