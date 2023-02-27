<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\NotificationEvent;

use ArtARTs36\MergeRequestLinter\Domain\Configuration\NotificationEventMessage;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Condition\OperatorResolver;

class ConditionListener implements Listener
{
    public function __construct(
        private readonly NotificationEventMessage $message,
        private readonly OperatorResolver $operator,
        private readonly Listener $listener,
    ) {
        //
    }

    public function handle(object $event): void
    {
        if (! $this->operator->resolve($this->message->conditions)->check($event)) {
            return;
        }

        $this->listener->handle($event);
    }
}
