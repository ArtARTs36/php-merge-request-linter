<?php

namespace ArtARTs36\MergeRequestLinter\Application\Comments\Message;

use ArtARTs36\MergeRequestLinter\Application\Comments\Contracts\UpdatingMessageFormatter;

final class AppendUpdatingMessageFormatter implements UpdatingMessageFormatter
{
    public function formatMessage(string $firstMessage, string $newMessage): string
    {
        return $firstMessage . "\n---\n" . $newMessage;
    }
}
