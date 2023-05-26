<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Shared\Events\EventListener;
use ArtARTs36\MergeRequestLinter\Shared\Events\EventManager;
use ArtARTs36\MergeRequestLinter\Shared\Events\EventSubscriber;

class NullEventDispatcher implements EventManager
{
    public function listen(string $event, EventListener $listener): void
    {
        // TODO: Implement listen() method.
    }

    public function subscribe(EventSubscriber $subscriber): void
    {
        // TODO: Implement subscribe() method.
    }

    public function dispatch(object $event): object
    {
        return $event;
    }
}
