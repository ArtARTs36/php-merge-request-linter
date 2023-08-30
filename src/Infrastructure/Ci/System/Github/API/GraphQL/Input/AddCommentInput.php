<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Input;

/**
 * @codeCoverageIgnore
 */
readonly class AddCommentInput
{
    public function __construct(
        public string $graphqlUrl,
        public string $subjectId,
        public string $message,
    ) {
        //
    }
}
