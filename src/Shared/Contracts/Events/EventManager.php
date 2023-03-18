<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Contracts\Events;

use ArtARTs36\MergeRequestLinter\Shared\Events\EventListener;
use ArtARTs36\MergeRequestLinter\Shared\Events\EventListenerWasFailedException;
use ArtARTs36\MergeRequestLinter\Shared\Events\EventSubscriber;
use Psr\EventDispatcher\EventDispatcherInterface;

/**
 * Event Manager.
 */
interface EventManager extends EventDispatcherInterface
{
    /**
     * Add Listener to event.
     * @param string|class-string $event
     * @param EventListener $listener
     * @throws EventListenerWasFailedException
     */
    public function listen(string $event, EventListener $listener): void;

    /**
     * Add subscriber.
     */
    public function subscribe(EventSubscriber $subscriber): void;
}
