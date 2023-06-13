<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Configuration;

/**
 * @codeCoverageIgnore
 */
class CommentsConfig
{
    /**
     * @param array<CommentsMessage> $messages
     */
    public function __construct(
        public readonly CommentsPostStrategy $postStrategy,
        public readonly array $messages,
    ) {
        //
    }
}
