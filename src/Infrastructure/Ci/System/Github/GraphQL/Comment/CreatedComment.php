<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Comment;

/**
 * @codeCoverageIgnore
 */
class CreatedComment
{
    public function __construct(
        public readonly string $id,
    ) {
        //
    }
}
