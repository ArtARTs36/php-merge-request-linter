<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Input;

/**
 * @codeCoverageIgnore
 */
class UpdateCommentInput
{
    public function __construct(
        public readonly string $graphqlUrl,
        public readonly string $commentId,
        public readonly string $message,
    ) {
        //
    }
}
