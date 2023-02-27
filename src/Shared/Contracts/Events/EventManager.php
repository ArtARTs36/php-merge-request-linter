<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Contracts\Events;

use ArtARTs36\MergeRequestLinter\Shared\Events\EventSubscriber;
use Psr\EventDispatcher\EventDispatcherInterface;

interface EventManager extends EventDispatcherInterface
{
    /**
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
