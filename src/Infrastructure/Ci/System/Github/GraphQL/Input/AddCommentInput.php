<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Input;

/**
 * @codeCoverageIgnore
 */
class AddCommentInput
{
    public function __construct(
        public readonly string $graphqlUrl,
        public readonly string $subjectId,
        public readonly string $message,
    ) {
        //
    }
}
