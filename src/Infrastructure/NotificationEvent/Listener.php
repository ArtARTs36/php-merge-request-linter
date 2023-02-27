<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\NotificationEvent;

/**
 * Event Listener.
 */
interface Listener
{
    /**
     * Handle event.
     */
    public function handle(object $event): void;
}
