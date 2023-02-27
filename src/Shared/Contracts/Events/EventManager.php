<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Contracts\Events;

use ArtARTs36\MergeRequestLinter\Shared\Events\EventSubscriber;
use Psr\EventDispatcher\EventDispatcherInterface;

/**
 * Event Manager.
 */
interface EventManager extends EventDispatcherInterface
{
    /**
     * Add Listener to event.
     * @template E as object
     * @param string|class-string<E> $event
     * @param callable(E): void $listener
     */
    public function listen(string $event, callable $listener): void;

    /**
     * Add subscriber.
     */
    public function subscribe(EventSubscriber $subscriber): void;
}
