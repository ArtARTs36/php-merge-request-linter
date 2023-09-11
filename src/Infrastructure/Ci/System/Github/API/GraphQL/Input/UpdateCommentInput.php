<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Input;

/**
 * @codeCoverageIgnore
 */
readonly class UpdateCommentInput
{
    public function __construct(
        public string $graphqlUrl,
        public string $commentId,
        public string $message,
    ) {
    }
}
