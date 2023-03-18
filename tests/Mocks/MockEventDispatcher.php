<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Shared\Contracts\Events\EventManager;
use ArtARTs36\MergeRequestLinter\Shared\Events\EventListener;
use ArtARTs36\MergeRequestLinter\Shared\Events\EventSubscriber;

class MockEventDispatcher implements EventManager
{
    public array $listeners = [];

    public function dispatch(object $event)
    {
        // TODO: Implement dispatch() method.
    }

    public function listen(string $event, EventListener $listener): void
    {
        $this->listeners[$event][] = $listener;
    }

    public function subscribe(EventSubscriber $subscriber): void
    {
        // TODO: Implement subscribe() method.
    }
}
