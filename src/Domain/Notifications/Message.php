<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Notifications;

use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Map;

/**
 * @codeCoverageIgnore
 */
class Message
{
    public function __construct(
        public readonly string $text,
        public readonly string $id,
    ) {
        //
    }
}
