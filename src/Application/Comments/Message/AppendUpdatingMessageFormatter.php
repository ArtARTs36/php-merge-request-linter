<?php

namespace ArtARTs36\MergeRequestLinter\Application\Comments\Message;

final class AppendUpdatingMessageFormatter implements UpdatingMessageFormatter
{
    public function formatMessage(string $firstMessage, string $newMessage): string
    {
        return $firstMessage . "\n---\n" . $newMessage;
    }
}
