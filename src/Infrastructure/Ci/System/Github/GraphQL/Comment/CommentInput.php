<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Comment;

/**
 * @codeCoverageIgnore
 */
class CommentInput
{
    public function __construct(
        public readonly string $graphqlUrl,
        public readonly string $subjectId,
        public readonly string $message,
    ) {
        //
    }
}
