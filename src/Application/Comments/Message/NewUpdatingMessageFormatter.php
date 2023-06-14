<?php

namespace ArtARTs36\MergeRequestLinter\Application\Comments\Message;

final class NewUpdatingMessageFormatter implements UpdatingMessageFormatter
{
    public function formatMessage(string $firstMessage, string $newMessage): string
    {
        return $newMessage;
    }
}
