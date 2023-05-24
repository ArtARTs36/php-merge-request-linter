<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Notifier;

use ArtARTs36\MergeRequestLinter\Domain\Notifications\Message;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Map;

class MessageCreator
{
    /**
     * @param Map<string, mixed> $data
     */
    public function create(string $template, Map $data): Message
    {
        return new Message($template, $data, uniqid());
    }
}
