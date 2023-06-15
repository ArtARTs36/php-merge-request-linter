<?php

namespace ArtARTs36\MergeRequestLinter\Application\Comments\Contracts;

/**
 * Interface for UpdatingMessageFormatter.
 */
interface UpdatingMessageFormatter
{
    /**
     * Format message.
     */
    public function formatMessage(string $firstMessage, string $newMessage): string;
}
