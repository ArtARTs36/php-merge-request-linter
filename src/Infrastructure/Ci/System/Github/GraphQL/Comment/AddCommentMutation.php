<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Comment;

class AddCommentMutation
{
    /**
     * @param array<string, mixed> $variables
     */
    public function __construct(
        public readonly string $query,
        public readonly array $variables,
    ) {
        //
    }
}
