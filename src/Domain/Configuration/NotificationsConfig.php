<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Configuration;

use ArtARTs36\MergeRequestLinter\Domain\Notifications\Channel;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Map;

/**
 * @phpstan-type EventName string
 * @codeCoverageIgnore
 */
readonly class NotificationsConfig
{
    /**
     * @param Map<string, Channel> $channels
     * @param Map<EventName, array<NotificationEventMessage>> $on
     */
    public function __construct(
        public Map $channels,
        public Map $on,
    ) {
        //
    }
}
