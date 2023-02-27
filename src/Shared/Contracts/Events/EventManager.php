<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Contracts\Events;

use ArtARTs36\MergeRequestLinter\Shared\Events\EventSubscriber;
use Psr\EventDispatcher\EventDispatcherInterface;

interface EventManager extends EventDispatcherInterface
{
    /**
     * @param string|class-string $event
     * @param callable(object): void $listener
     */
    public function listen(string $event, callable $listener): void;

    /**
     * Add subscriber.
     */
    public function subscribe(EventSubscriber $subscriber): void;
}
