<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Shared\Contracts\Events\EventManager;
use ArtARTs36\MergeRequestLinter\Shared\Events\EventSubscriber;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class NullEventDispatcher implements EventManager
{
    public function listen(string $event, callable $listener): void
    {
        // TODO: Implement listen() method.
    }

    public function subscribe(EventSubscriber $subscriber): void
    {
        // TODO: Implement subscribe() method.
    }

    public function dispatch(object $event, string $eventName = null): object
    {
        return $event;
    }
}
