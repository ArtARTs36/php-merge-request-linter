<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Events;

/**
 * Interface for event subscribers.
 * @phpstan-type EventName string|class-string
 * @phpstan-type MethodName string
 */
interface EventSubscriber
{
    /**
     * Get event map.
     * @return array<EventName, MethodName>
     */
    public function getSubscribedEvents(): array;
}
