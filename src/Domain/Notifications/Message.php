<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Notifications;

/**
 * @codeCoverageIgnore
 */
readonly class Message
{
    public function __construct(
        public string $text,
        public string $id,
    ) {
    }
}
