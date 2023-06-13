<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Configuration;

/**
 * @codeCoverageIgnore
 */
class CommentsConfig
{
    public function __construct(
        public readonly CommentsPostStrategy $postStrategy,
    ) {
    }
}
