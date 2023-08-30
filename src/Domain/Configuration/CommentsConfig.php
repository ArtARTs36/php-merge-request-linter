<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Configuration;

/**
 * @codeCoverageIgnore
 */
readonly class CommentsConfig
{
    /**
     * @param array<CommentsMessage> $messages
     */
    public function __construct(
        public CommentsPostStrategy $postStrategy,
        public array                $messages,
    ) {
        //
    }
}
