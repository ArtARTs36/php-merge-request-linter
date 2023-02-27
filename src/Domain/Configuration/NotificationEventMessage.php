<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Configuration;

use ArtARTs36\MergeRequestLinter\Domain\Notifications\Channel;

class NotificationEventMessage
{
    /**
     * @param array<mixed> $conditions
     */
    public function __construct(
        public readonly string $event,
        public readonly Channel $channel,
        public readonly string $template,
        public readonly array $conditions,
    ) {
        //
    }
}
