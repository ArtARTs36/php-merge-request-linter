<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Events;

/**
 * @phpstan-type EventName string|class-string
 * @phpstan-type MethodName string
 */
interface EventSubscriber
{
    /**
     * @return array<EventName, MethodName>
     */
    public function getSubscribedEvents(): array;
}
