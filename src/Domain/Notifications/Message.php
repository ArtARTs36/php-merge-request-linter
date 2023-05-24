<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Notifications;

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
