<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\NotificationEvent;

use ArtARTs36\MergeRequestLinter\Domain\Configuration\NotificationEventMessage;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Condition\OperatorResolver;
use ArtARTs36\ContextLogger\Contracts\ContextLogger;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Contracts\Notifier;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Notifier\MessageCreator;

class ListenerFactory
{
    public function __construct(
        private readonly Notifier $notifier,
        private readonly OperatorResolver $operator,
        private readonly MessageCreator $messageCreator,
        private readonly ContextLogger $contextLogger,
    ) {
    }

    public function create(NotificationEventMessage $message): Listener
    {
        $notifyListener = new NotifyListener(
            $this->notifier,
            $message,
            $this->messageCreator,
            $this->contextLogger,
        );

        if (empty($message->conditions)) {
            return $notifyListener;
        }

        return new ConditionListener($message, $this->operator, $notifyListener);
    }
}
