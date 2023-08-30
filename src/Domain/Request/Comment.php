<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Request;

/**
 * @codeCoverageIgnore
 */
readonly class Comment
{
    public function __construct(
        public string $id,
        public string $message,
        public string $mergeRequestId,
    ) {
        //
    }
}
