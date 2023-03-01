<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Notifications;

use ArtARTs36\MergeRequestLinter\Shared\Contracts\DataStructure\Map;

/**
 * @codeCoverageIgnore
 */
class Channel
{
    /**
     * @param Map<string, mixed> $params
     */
    public function __construct(
        public readonly ChannelType $type,
        public readonly Map $params,
    ) {
        //
    }
}
