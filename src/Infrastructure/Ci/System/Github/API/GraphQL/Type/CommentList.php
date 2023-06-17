<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Type;

use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;

/**
 * @codeCoverageIgnore
 */
class CommentList
{
    /**
     * @param Arrayee<int, Comment> $comments
     */
    public function __construct(
        public readonly Arrayee $comments,
        public readonly bool $hasNextPage,
        public readonly ?string $endCursor,
    ) {
        //
    }
}
