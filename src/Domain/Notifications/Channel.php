<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Notifications;

use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Shared\Time\TimePeriod;

/**
 * @codeCoverageIgnore
 */
readonly class Channel
{
    /**
     * @param Map<string, mixed> $params
     */
    public function __construct(
        public ChannelType $type,
        public Map         $params,
        public TimePeriod  $sound,
    ) {
    }
}
