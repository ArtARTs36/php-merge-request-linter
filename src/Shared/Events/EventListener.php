<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Events;

/**
 * Interface for event listeners.
 */
interface EventListener
{
    /**
     * Get listener name.
     */
    public function name(): string;

    /**
     * Call listener.
     */
    public function call(object $event): void;
}
