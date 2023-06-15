<?php

namespace ArtARTs36\MergeRequestLinter\Application\Comments\Message;

use ArtARTs36\MergeRequestLinter\Application\Comments\Contracts\UpdatingMessageFormatter;

final class NewUpdatingMessageFormatter implements UpdatingMessageFormatter
{
    public function formatMessage(string $firstMessage, string $newMessage): string
    {
        return $newMessage;
    }
}
