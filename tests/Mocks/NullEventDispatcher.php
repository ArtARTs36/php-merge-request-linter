<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class NullEventDispatcher implements EventDispatcherInterface
{
    public function addListener(string $eventName, callable $listener, int $priority = 0)
    {
        // TODO: Implement addListener() method.
    }

    public function addSubscriber(EventSubscriberInterface $subscriber)
    {
        // TODO: Implement addSubscriber() method.
    }

    public function removeListener(string $eventName, callable $listener)
    {
        // TODO: Implement removeListener() method.
    }

    public function removeSubscriber(EventSubscriberInterface $subscriber)
    {
        // TODO: Implement removeSubscriber() method.
    }

    public function getListeners(string $eventName = null): array
    {
        return [];
    }

    public function dispatch(object $event, string $eventName = null): object
    {
        return $event;
    }

    public function getListenerPriority(string $eventName, callable $listener): ?int
    {
        return null;
    }

    public function hasListeners(string $eventName = null): bool
    {
        return false;
    }
}
