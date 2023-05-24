<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\NotificationEvent;

/**
 * Event Listener.
 */
interface Listener
{
    /**
     * Handle event.
     * @throws NotifyFailedException
     */
    public function handle(object $event): void;
}
