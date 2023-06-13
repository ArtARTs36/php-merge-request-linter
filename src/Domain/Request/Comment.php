<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Request;

/**
 * @codeCoverageIgnore
 */
class Comment
{
    public function __construct(
        public readonly string $message,
    ) {
        //
    }
}
